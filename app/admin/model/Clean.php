<?php

namespace app\admin\model;

use \core\lib\DB;

class Clean extends DB
{

    function getEditorList()
    {
        $pattern = '/upload\/editor\/image\/[a-zA-Z0-9]+\.(jpg|png|gif)/';
        $tables = [
            'article' => ['content'],
            'page' => ['content'],
            'product' => ['content']
        ];
        $list = [];
        foreach ($tables as $table => $fields) {
            $rows = $this->table($table)->select('', implode(',', $fields));
            foreach ($rows as $row) {
                $subject = implode('|', $row);
                preg_match_all($pattern, $subject, $matches);
                if ($matches) {
                    $list = array_merge($list, $matches[0]);
                }
            }
        }

        //setting
        $settings = setting();
        $content = implode('|', $settings);
        preg_match_all($pattern, $content, $matches);
        if ($matches) {
            $list = array_merge($list, $matches[0]);
        }

        $files = glob('upload/editor/image/*.{jpg,png,gif}', GLOB_BRACE);
        return $files ? array_diff($files, $list) : [];
    }

    function getFileList()
    {
        $field = 'file';
        $rows = $this->table('file')->select("WHERE `{$field}`!=''", $field);
        $list = array_column($rows, $field);
        $files = glob('upload/file/*.{rar,zip,7z,doc,docx,xls,xlsx,ppt,pptx,pdf}', GLOB_BRACE);
        return $files ? array_diff($files, $list) : [];
    }

    function getImageList()
    {
        $field = 'img';
        $rows = $this->table('image')->select("WHERE `{$field}`!=''", $field);
        $list = array_column($rows, $field);
        $files = glob('upload/image/*.{jpg,png,gif}', GLOB_BRACE);
        return $files ? array_diff($files, $list) : [];
    }

    function getPhotoList()
    {
        $rows = $this->table('photo')->select('WHERE `img1`!="" OR `img2`!=""', 'img1,img2');
        $list = [];
        foreach ($rows as $val) {
            $list[] = $val['img1'];
            $list[] = $val['img2'];
        }
        $files = glob('upload/photo/*.{jpg,png,gif}', GLOB_BRACE);
        return $files ? array_diff($files, $list) : [];
    }

    function getProductList()
    {
        $rows = $this->table('product')->select('WHERE `img1`!="" OR `img2`!="" OR `album`!=""', 'img1,img2,album');
        $list = [];
        foreach ($rows as $val) {
            $list[] = $val['img1'];
            $list[] = $val['img2'];
            if ($val['album']) {
                $album = json_decode($val['album'], true);
                foreach ($album as $v) {
                    $list[] = $v['img1'];
                    $list[] = $v['img2'];
                }
            }
        }
        $files = glob('upload/product/*.{jpg,png,gif}', GLOB_BRACE);
        return $files ? array_diff($files, $list) : [];
    }

    function getSettingList()
    {
        $list = [];
        $list[] = setting('watermark_img');
        $list[] = setting('logo');
        $files = glob('upload/setting/*.{jpg,png,gif}', GLOB_BRACE);
        return $files ? array_diff($files, $list) : [];
    }

}