<?php

namespace app\admin\controller;

use \core\lib\Controller;
use \core\lib\Validation;

class Login extends Controller
{

    function indexAction()
    {
        if (isset($_SESSION['user']['id']) && isset($_SESSION['user']['account']) && isset($_SESSION['user']['password'])) {
            header('Location:index.html');
        } else {
            $this->display();
        }
    }

    //登录查询
    function queryAction()
    {
        if (!(IS_AJAX && IS_POST)) {
            $this->ajaxReturn(0, '非法请求');
        }

        if (isset($_POST['captcha'])) {
            $_POST['captcha'] = strtoupper($_POST['captcha']);
        }

        //数据验证
        $rules = [
            ['account', 'required', '请输入帐号'],
            ['account', '/^[A-Za-z0-9_\-.]{4,16}$/', '帐号格式错误'],
            ['password', 'required', '请输入密码'],
            ['password', '/^[a-z0-9]{32}$/', '密码格式错误'],
            ['captcha', 'required', '请输入验证码'],
            ['captcha', '/^[A-Za-z0-9]{4}$/', '验证码格式错误'],
            ['captcha', 'equal', '验证码错误', session('captcha')]
        ];

        $valid = new Validation($_POST, $rules);
        if (false === $valid->check()) {
            $this->ajaxReturn(0, $valid->getError());
        }

        //数据查询
        unset($_SESSION['captcha']); //删除验证码
        $account = $_POST['account'];
        $password = $_POST['password'];
        $db = D('user');
        $user = $db->fetch("WHERE `account`='{$account}' AND `password`='{$password}'", 'id,name,account,password,rights,login_number');
        if ($user) {
            $user['rights'] = $user['rights'] ? json_decode($user['rights'], true) : [];
            $_SESSION['user'] = $user;
            $this->backup(); //数据库备份
            $db->update(['login_number' => $user['login_number'] + 1, 'last_login_time' => time(), 'last_login_ip' => ip2long($_SERVER["REMOTE_ADDR"])], $user['id']); //更新最后登录信息
            $this->ajaxReturn(1, '登录成功');
        } else {
            $this->ajaxReturn(0, '帐号或密码错误');
        }
    }

    //数据库备份
    private function backup()
    {
        $dir = 'backup/sql/';
        $file = $dir . SITE_TOKEN . '_sql_' . date('Ymd_His') . '.zip';
        $db = new \app\admin\model\Backup();
        $db->run($file);
        $files = glob($dir . '*.zip');
        rsort($files);
        $total = count($files);
        if ($total > 15) {
            for ($i = 15; $i < $total; $i++) {
                unlink($files[$i]);
            }
        }
    }

}