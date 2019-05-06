<?php

namespace app\home\controller;

use core\lib\Validation;

class Message extends Base
{

    function indexAction()
    {
        $this->assign('title', '客户留言_' . setting('site_name'));
        $this->display();
    }

    //提交表单
    function insertAction()
    {
        if (!(IS_AJAX && IS_POST)) {
            exit;
        }

        //数据验证
        $rules = [
            ['company', 'required', '请输入公司名称'],
            ['contact_person', 'required', '请输入联系人'],
            ['phone', 'required', '请输入电话号码'],
            ['email', 'required', '请输入邮箱地址'],
            ['email', 'email', '邮箱地址格式错误'],
            ['message', 'required', '请输入留言内容']
        ];

        $valid = new Validation($_POST, $rules);
        if (false === $valid->check()) {
            $this->ajaxReturn(0, $valid->getError());
        }

        //插入数据
        $data = [];
        $data['type'] = $_POST['type'];
        if ($data['type'] == 0) {
            $data['subject'] = '客户留言：' . $_POST['company'];
        } else {
            $data['subject'] = '在线询盘：' . $_POST['company'];
        }
        $default = ['company' => '', 'contact_person' => '', 'phone' => '', 'email' => '', 'message' => ''];
        $content = array_intersect_key($_POST, $default);
        $data['content'] = json_encode($content);
        $data['create_time'] = time();
        $result = D('message')->insert(array_map('strip_tags', $data));
        $result ? $this->ajaxReturn(1, '留言提交成功') : $this->ajaxReturn(0, '留言提交失败');
    }

}