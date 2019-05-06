<?php

namespace app\admin\controller;

use \core\lib\Pagination;
use \core\lib\FileUpload;
use \core\lib\Image;
use \core\lib\Tree;

class Product extends Base
{
    const TABLE = 'product';
    const IMAGE_BIG_WIDTH = 800;
    const IMAGE_BIG_HEIGHT = 600;
    const IMAGE_SMALL_WIDTH = 320;
    const IMAGE_SMALL_HEIGHT = 240;

    function indexAction()
    {
        $this->assign('title', '产品列表_产品管理');
        $this->common();

        $t1 = DB_TABLE_PRE . 'product';
        $t2 = DB_TABLE_PRE . 'product_category';
        $field = "{$t1}.id, {$t1}.name, {$t1}.img1, {$t1}.img2, {$t1}.is_show, {$t1}.is_tj, {$t1}.orderly, {$t2}.cat_name ";
        $sql = "SELECT {$field} FROM {$t1} LEFT JOIN {$t2} ON {$t1}.cat={$t2}.id ";

        $search = [];

        $cat = get('cat');
        if ($cat && is_numeric($cat)) {
            $inCat = $this->tree->getFamilyId($cat);
            $search[] = "`cat` IN({$inCat})";
        }

        $name = get('name');
        if ($name) {
            $search[] = "`name` LIKE '%{$name}%'";
        }

        if ($search) {
            $sql .= 'WHERE ' . implode($search, ' AND ');
        }

        $db = D();
        $setting = setting();
        $total = count($db->query($sql)->fetchAll());
        $pagination = new Pagination($total, $setting['product_count']);
        $rows = $db->query("$sql ORDER BY `orderly` {$setting['product_order']} {$pagination->limit}")->fetchAll();

        $this->assign([
            'rows' => $rows,
            'paging' => $pagination->output('info,prev,item,next')
        ]);

        $this->display();
    }

    function batchAction($type = '', $cat = 0)
    {
        $this->batch($type);
        $db = D(self::TABLE);
        $idStr = implode(',', $_POST['id']);
        if ($type == 'sort') {
            $orderly = array_intersect_key($_POST['orderly'], $_POST['id']);
            foreach ($orderly as $key => $value) {
                $db->update(['id' => $key, 'orderly' => $value]);
            }
            $this->ajaxReturn(1, '操作成功');
        } else if ($type == 'del') {
            $db->delete("WHERE `id` IN($idStr)") ? $this->ajaxReturn(1, '操作成功') : $this->ajaxReturn(0, '操作失败');
        } else if ($type == 'move' && $cat) {
            $result = $db->update(['cat' => $cat], "`id` IN($idStr)");
            ($result !== false) ? $this->ajaxReturn(1, '操作成功') : $this->ajaxReturn(0, '操作失败');
        }
    }

    function delAction($id = 0)
    {
        $this->param($id && is_numeric($id));
        D(self::TABLE)->delete($id) ? $this->success('删除成功') : $this->failure('删除失败');
    }

    function addAction()
    {
        $this->assign('title', '添加产品_产品管理');
        $this->common();
        $this->display();
    }

    function insertAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        $_POST['album'] = isset($_POST['album']) ? array_values($_POST['album']) : [];
        foreach ($_POST as $key => $val) {
            if (is_array($val)) {
                $_POST[$key] = json_encode($val);
            }
        }
        D(self::TABLE)->insert($_POST) ? jump('添加成功', CONTROLLER_URL) : alert('添加失败');
    }

    function editAction($id = 0)
    {
        $this->assign('title', '编辑产品_产品管理');
        $db = D(self::TABLE);
        $data = $db->fetch(intval($id));
        $or = $data['orderly'];
        $up = $db->fetch("WHERE `orderly` > $or ORDER BY `orderly` ASC", 'id'); //上一条
        $down = $db->fetch("WHERE `orderly` < $or ORDER BY `orderly` DESC", 'id'); //下一条
        if (setting('product_order') == 'DESC') {
            $prev = $up;
            $next = $down;
        } else {
            $prev = $down;
            $next = $up;
        }

        $this->assign(compact('data', 'prev', 'next'));
        $this->common();
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));

        $_POST['album'] = isset($_POST['album']) ? array_values($_POST['album']) : [];
        foreach ($_POST as $key => $val) {
            if (is_array($val)) {
                $_POST[$key] = json_encode($val);
            }
        }
        $_POST['is_tj'] = post('is_tj', 0);
        $_POST['is_show'] = post('is_show', 0);
        $result = D(self::TABLE)->update($_POST);
        ($result !== false) ? jump('更新成功', -2) : alert('更新失败');
    }

    function uploadAction()
    {
        $fu = new FileUpload('product');
        $fu->namingRules = 'time';
        $file = $fu->upload();
        if (!$file) {
            $this->ajaxReturn(0, $fu->error());
        }

        $setting = setting();
        $Image = new Image;

        $img1 = Image::rename($file, '_1');
        $Image->open($file)->fill(self::IMAGE_BIG_WIDTH, self::IMAGE_BIG_HEIGHT);
        if ($setting['watermark']) {
            $Image->marge($setting['watermark_img'], $setting['watermark_position']);
        }
        $Image->save($img1);

        $img2 = Image::rename($file, '_2');
        $Image->open($file)->clip(self::IMAGE_SMALL_WIDTH, self::IMAGE_SMALL_HEIGHT)->save($img2);

        unlink($file);
        $this->ajaxReturn(1, '上传成功', ['img1' => $img1, 'img2' => $img2]);
    }

    function uploadsAction()
    {
        if (!isset($_FILES['file'])) {
            $this->error('非法请求');
        }

        $setting = setting();
        $fu = new FileUpload('product');
        $fu->namingRules = 'time';
        $Image = new Image;

        $files = $_FILES['file'];
        $count = count($files['name']);
        $success = $failure = 0;
        $images = [];
        for ($i = 0; $i < $count; $i++) {
            $file = $fu->uploads($files, $i);
            if ($file) {
                $img1 = Image::rename($file, '_1');
                $Image->open($file)->fill(self::IMAGE_BIG_WIDTH, self::IMAGE_BIG_HEIGHT);
                if ($setting['watermark']) {
                    $Image->marge($setting['watermark_img'], $setting['watermark_position']);
                }
                $Image->save($img1);

                $img2 = Image::rename($file, '_2');
                $Image->open($file)->clip(self::IMAGE_SMALL_WIDTH, self::IMAGE_SMALL_HEIGHT)->save($img2);

                unlink($file);
                $images[] = ['img1' => $img1, 'img2' => $img2];
                $success++;
            } else {
                $failure++;
            }
        }
        if ($success && $failure) {
            $status = 1;
            $message = "{$success} 张图片上传成功, {$failure} 张图片上传失败";
        } else if ($success) {
            $status = 1;
            $message = "{$success} 张图片上传成功";
        } else {
            $status = 0;
            $message = "{$failure} 张图片上传失败";
        }
        $this->ajaxReturn($status, $message, $images);
    }

    function ajaxAction($type = 'show', $id = 0)
    {
        $this->method(IS_AJAX);
        $this->param($id && is_numeric($id));

        $data = ['id' => $id];
        if ($type == 'show') {
            $data['is_show'] = get('val');
        } else {
            $data['is_tj'] = get('val');
        }
        if (D(self::TABLE)->update($data) !== false) {
            $this->ajaxReturn(1, '更新成功');
        } else {
            $this->ajaxReturn(0, '更新失败');
        }
    }

    private function common()
    {
        $category = D('product_category')->select('ORDER BY `orderly` ASC', 'id, pid, cat_name');
        $this->tree = new Tree($category);
    }

}