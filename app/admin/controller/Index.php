<?php

namespace app\admin\controller;

class Index extends Base
{

    function indexAction()
    {
        $this->assign('title', '后台首页');
        $this->display();
    }

    function logoutAction()
    {
        $this->logout(); //退出登录
    }

}