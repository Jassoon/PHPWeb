<?php

namespace app\admin\controller;

use \core\lib\Controller;

class Base extends Controller
{

    protected function _init()
    {
        $this->layout('Layout')->assign('title', '网站管理');

        //登录验证
        if (isset($_SESSION['user']['id']) && isset($_SESSION['user']['account']) && isset($_SESSION['user']['password'])) {
            define('USER_ID', $_SESSION['user']['id']);
        } else {
            $this->logout($_SERVER["REQUEST_URI"]);
        }

        //权限验证
        if (!$this->auth(CONTROLLER, ACTION)) {
            $this->error('很抱歉，你没有权限请求此页面！');
        }
    }

    /**
     * 权限验证
     * @param string $c 控制器名称
     * @param string $a 操作名称
     * @return bool
     */
    function auth($c, $a = '')
    {
        //超级管理员免验证
        if (USER_ID == 1) {
            return true;
        }

        //当前用户拥有的权限
        $rights = $_SESSION['user']['rights'];
        if (!is_array($rights)) {
            return false;
        }

        //需要验证的权限
        static $authList = null;
        if (is_null($authList)) {
            $nodes = import(MODULE_DIR . 'auth_nodes.php');
            $authList = [];
            foreach ($nodes as $k => $v) {
                $authList[$k] = array_keys($v['nodes']);
            }
        }

        //如果控制器不在需要验证的数组内，则不用验证
        if (!array_key_exists($c, $authList)) {
            return true;
        }

        $controllerResult = array_key_exists($c, $rights);
        if ($controllerResult && $a && in_array($a, $authList[$c])) {
            return ($controllerResult && in_array($a, $rights[$c]));
        } else {
            return $controllerResult;
        }
    }

    //退出登录
    function logout($src = '')
    {
        unset($_SESSION['user']);
        session_destroy();
        $url = url('login');
        if ($src) {
            $url .= '?src=' . urlencode($src);
        }
        header('Location:' . $url);
        exit;
    }

    //Error
    function error($message = '&#38750;&#27861;&#35831;&#27714;')
    {
        if (IS_AJAX) {
            $this->ajaxReturn(0, $message);
        } else {
            $this->assign('message', $message);
            $this->display('Error');
        }
        exit;
    }

    function _empty()
    {
        $this->error('很抱歉，你访问的页面不存在！');
    }

    //成功提示
    function success($text)
    {
        IS_AJAX ? $this->ajaxReturn(1, $text) : jump($text);
    }

    //失败提示
    function failure($text)
    {
        IS_AJAX ? $this->ajaxReturn(0, $text) : alert($text);
    }

    //HTTP方法验证
    function method($result)
    {
        if (!$result) {
            $this->error('请求错误');
        }
    }

    //简易参数验证
    function param($result)
    {
        if (!$result) {
            $this->failure('参数错误');
        }
    }

    //Batch
    protected function batch($type)
    {
        $this->method(IS_POST && IS_AJAX);
        $this->param(in_array($type, ['sort', 'del', 'move']));
        if (empty($_POST['id'])) {
            $this->ajaxReturn(0, '请选择你要操作的内容');
        }
    }

}