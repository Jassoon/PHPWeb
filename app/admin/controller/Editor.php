<?php

namespace app\admin\controller;

use \core\lib\Controller;
use \core\lib\FileUpload;

class Editor extends Controller
{

    //文件上传
    function uploadAction()
    {
        $basePath = 'editor/';
        $extArr = [
            'image' => ['gif', 'jpg', 'jpeg', 'png', 'bmp'],
            'flash' => ['swf', 'flv'],
            'media' => ['swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'],
            'file' => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'],
        ];

        if (!isset($_FILES['imgFile'])) {
            $this->alert('请选择文件');
        }

        $dir = get('dir', 'image');
        if (!array_key_exists($dir, $extArr)) {
            $this->alert('目录名错误');
        }

        $fu = new FileUpload($basePath . $dir);
        $fu->types = $extArr[$dir];

        $file = $fu->upload($_FILES['imgFile']);
        if (!$file) {
            $this->alert($fu->error());
        }

        header('Content-type: text/html; charset=UTF-8');
        echo json_encode(['error' => 0, 'url' => $file]);
    }

    //文件管理
    function managerAction()
    {
        $root_path = 'upload/editor/'; //根目录路径
        $root_url = 'upload/editor/'; //根目录URL
        $ext_arr = ['gif', 'jpg', 'jpeg', 'png', 'bmp']; //图片扩展名

        //目录名
        $dir_name = get('dir', 'image');
        if (!in_array($dir_name, ['image', 'flash', 'media', 'file'])) {
            exit('目录名称无效');
        }

        $root_path .= $dir_name . "/";
        $root_url .= $dir_name . "/";
        if (!is_dir($root_path)) {
            mkdir($root_path);
        }

        //根据path参数，设置各路径和URL
        $path = get('path');
        if (empty($path)) {
            $current_path = realpath($root_path) . '/'; //当前绝对目录
            $current_url = $root_url; //当前URL
            $current_dir_path = ''; //当前文件夹路径
            $moveup_dir_path = ''; //上一层文件夹路径
        } else {
            $current_path = realpath($root_path) . '/' . $path;
            $current_url = $root_url . $path;
            $current_dir_path = $path;
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }

        //不允许使用..移动到上一级目录
        if (preg_match('/\.\./', $current_path)) {
            exit('禁止访问');
        }

        //最后一个字符不是/
        if (!preg_match('/\/$/', $current_path)) {
            exit('无效参数');
        }
        //目录不存在或不是目录
        if (!file_exists($current_path) || !is_dir($current_path)) {
            exit('目录不存在');
        }

        //遍历目录取得文件信息
        $file_list = [];
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
                if ($filename{0} == '.') {
                    continue;
                }
                $file = $current_path . $filename;
                if (is_dir($file)) {
                    $file_list[$i]['is_dir'] = true; //是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; //文件大小
                    $file_list[$i]['is_photo'] = false; //是否图片
                    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
                } else {
                    $file_list[$i]['is_dir'] = false;
                    $file_list[$i]['has_file'] = false;
                    $file_list[$i]['filesize'] = filesize($file);
                    $file_list[$i]['dir_path'] = '';
                    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
                    $file_list[$i]['filetype'] = $file_ext;
                }
                $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
                $i++;
            }
            closedir($handle);
        }

        //排序
        usort($file_list, function ($a, $b) {
            $order = strtolower(get('order', 'name'));
            if ($a['is_dir'] && !$b['is_dir']) {
                return -1;
            } else if (!$a['is_dir'] && $b['is_dir']) {
                return 1;
            } else {
                if ($order == 'size') {
                    if ($a['filesize'] > $b['filesize']) {
                        return 1;
                    } else if ($a['filesize'] < $b['filesize']) {
                        return -1;
                    } else {
                        return 0;
                    }
                } else if ($order == 'type') {
                    return strcmp($a['filetype'], $b['filetype']);
                } else {
                    return strcmp($a['filename'], $b['filename']);
                }
            }
        });

        $result = [];
        $result['moveup_dir_path'] = $moveup_dir_path; //相对于根目录的上一级目录
        $result['current_dir_path'] = $current_dir_path; //相对于根目录的当前目录
        $result['current_url'] = $current_url; //当前目录的URL
        $result['total_count'] = count($file_list); //文件数
        $result['file_list'] = $file_list; //文件列表数组

        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($result);
    }

    //alert
    function alert($msg)
    {
        header('Content-type: text/html; charset=UTF-8');
        echo json_encode(['error' => 1, 'message' => $msg]);
        exit;
    }

}