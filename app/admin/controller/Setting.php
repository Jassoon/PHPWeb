<?php

namespace app\admin\controller;

use \core\lib\FileUpload;
use \core\lib\Cache;

class Setting extends Base
{
    public $navList = [
        'index' => '基本设置',
        'home' => '首页设置',
        'rule' => '常规设置',
        'code' => '插件代码'
    ];

    //基本
    function indexAction()
    {
        $this->assign('title', '基本设置_系统设置');
        $this->display();
    }

    //首页
    function homeAction()
    {
        $this->assign('title', '首页设置_系统设置');
        $this->display();
    }

    //常规
    function ruleAction()
    {
        $this->assign('title', '常规设置_系统设置');
        $this->display();
    }

    //插件代码
    function codeAction()
    {
        $this->assign('title', '插件代码_系统设置');
        $this->display();
    }

    //上传
    function uploadAction()
    {
        $fu = new FileUpload('setting');
        $file = $fu->upload();
        if (!$file) {
            $this->ajaxReturn(0, $fu->error());
        }
        $this->ajaxReturn(1, '上传成功', $file);
    }

    //更新
    function updateAction()
    {
        $this->method(IS_POST && IS_AJAX);
        $data = array_intersect_key($_POST, setting());
        $db = D('setting');
        foreach ($data as $key => $value) {
            $db->update(['setting_val' => $value], "`setting_key`='{$key}' LIMIT 1");
        }
        Cache::delete('setting');
        $this->ajaxReturn(1, '保存成功');
    }

}