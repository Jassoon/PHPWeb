<?php

namespace app\admin\controller;

use \core\lib\Validation;

class Password extends Base
{

    function indexAction()
    {
        $this->assign('title', '修改密码');
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST && IS_AJAX);
        $_POST['old'] = md5($_POST['old']);
        $rules = [
            ['old', 'required', '请输入原密码'],
            ['old', 'equal', '原密码错误', $_SESSION['user']['password']],
            ['password', 'required', '请输入新密码'],
            ['password', '/^[A-Za-z0-9_\-.]{4,16}$/', '新密码格式错误']
        ];

        $valid = new Validation($_POST, $rules);
        if (false === $valid->check()) {
            $this->ajaxReturn(0, $valid->getError());
        }

        $data = [
            'id' => USER_ID,
            'password' => md5($_POST['password'])
        ];

        if (D('user')->update($data) !== false) {
            unset($_SESSION['user']);
            session_destroy();
            $this->ajaxReturn(1, '密码修改成功，请重新登录');
        } else {
            $this->ajaxReturn(0, '密码修改失败');
        }
    }

}