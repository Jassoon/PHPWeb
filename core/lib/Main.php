<?php
/**
 * Class Main
 * @package core\lib
 */

namespace core\lib;

class Main
{
    private static $instance = null;

    static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        date_default_timezone_set('PRC'); //时区设置
        spl_autoload_register([__CLASS__, 'autoload']); //注册自动加载函数

        //错误日志设置
        if (DEBUG) {
            ini_set('display_errors', 1);
            error_reporting(E_ALL); //提示所有错误
        } else {
            ini_set('display_errors', 0);
            error_reporting(E_ALL ^ E_NOTICE); //关闭注意
            ini_set('log_errors', 'on'); //开启错误日志
            if (!is_dir(RUNTIME_LOG_DIR)) {
                mkdir(RUNTIME_LOG_DIR, 0777, true); //创建错误日志文件夹
            }
            ini_set('error_log', RUNTIME_LOG_DIR . date('Ymd') . '.log'); //指定错误日志文件
        }

        $this->run();
    }

    private function run()
    {
        $arguments = Router::parse(); // 请求处理
        $nameSpace = sprintf('\app\%s\controller\\', MODULE);

        if (class_exists($nameSpace . CONTROLLER)) {
            $className = $nameSpace . CONTROLLER;
        } else if (class_exists($nameSpace . 'Error')) {
            $className = $nameSpace . 'Error';
        } else {
            halt('The Controller: ' . CONTROLLER . ' is not exists!');
            return;
        }

        $controller = new $className();
        call_user_func_array([$controller, ACTION . 'Action'], $arguments);
    }

    private function autoload($name)
    {
        $name = str_replace('\\', '/', $name);
        $file = ROOT_DIR . $name . '.php';
        if (is_file($file)) {
            include($file);
        }
    }
}