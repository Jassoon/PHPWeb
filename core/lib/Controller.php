<?php
/**
 * Class Controller
 * @package core\lib
 */

namespace core\lib;

class Controller extends View
{

    function __construct()
    {
        if (C('SESSION_START')) {
            session_set_cookie_params(0, BASE_URL);
            session_start();
        }
        if (method_exists($this, '_init')) {
            $this->_init();
        }
    }

    function __call($name, $arguments)
    {
        if ($name === ACTION . 'Action') {
            if (method_exists($this, '_empty')) {
                $this->_empty($name, $arguments); // 如果存在空方法，则直接调用空方法
            } else if (is_file($this->realView())) {
                $this->display(); // 如果存在当前求的视图文件，则直接加载
            } else {
                halt('The Action: ' . ACTION . ' is not exists!');
            }
        } else {
            halt('The Function: ' . $name . ' is not exists!');
        }
    }

    /**
     * Ajax 返回JSON数据
     * @param bool $code 状态
     * @param string $msg 消息
     * @param string $data 数据
     */
    function ajaxReturn($code, $msg, $data = '')
    {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(compact('code', 'msg', 'data'));
        exit;
    }

}