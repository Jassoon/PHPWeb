<?php

namespace app\admin\controller;

class Clean extends Base
{

    function indexAction($type = 'editor')
    {
        $db = new \app\admin\model\Clean();
        $fn = sprintf('get%sList', ucfirst($type));
        $this->param(method_exists($db, $fn));
        $list = call_user_func([$db, $fn]);
        $rows = array_map(function ($v) {
            $ext = pathinfo($v, PATHINFO_EXTENSION);
            return [
                'file' => $v,
                'time' => date('Y-m-d H:i:s', filemtime($v)),
                'size' => file_size(filesize($v)),
                'icon' => in_array($ext, ['jpg', 'png', 'gif']) ? $v : src("admin/image/{$ext}.png")
            ];
        }, $list);
        $this->assign([
            'title' => '无效文件_文件整理',
            'list' => ['editor', 'file', 'image', 'photo', 'product', 'setting'],
            'navIndex' => $type,
            'rows' => $rows
        ]);
        $this->display();
    }

    function delAction()
    {
        $this->method(IS_POST && IS_AJAX);
        $file = post('file');
        $this->param($file && is_file($file));
        unlink($file) ? $this->ajaxReturn(1, '删除成功') : $this->ajaxReturn(0, '删除失败');
    }

}