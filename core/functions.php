<?php

use \core\lib\DB;

/**
 * 如果文件存在就include进来
 * @param $file
 * @return bool|mixed
 */
function import($file)
{
    if (is_file($file)) {
        return include $file;
    }
    return false;
}

/**
 * 终止程序运行
 * @param string $error 终止原因
 * @return void
 */
function halt($error)
{
    if (DEBUG) {
        $trace = debug_backtrace();
        $e['message'] = $error;
        $e['file'] = $trace[0]['file'];
        $e['line'] = $trace[0]['line'];
        ob_start();
        debug_print_backtrace();
        $e['trace'] = ob_get_clean();
    } else {
        $e['message'] = $error;
    }
    include(CORE_DIR . 'tpl/exception.php');
    exit;
}

/**
 * 加载配置文件
 * @param $file
 */
function load_config($file)
{
    $config = import($file);
    if ($config && is_array($config)) {
        C($config);
    }
}

/**
 * 获取和设置配置参数 支持批量定义
 * 如果$key是关联型数组，则会按K-V的形式写入配置
 * 如果$key是数字索引数组，则返回对应的配置数组
 * @param string|array $key 配置变量
 * @param array|null $value 配置值
 * @return array|null
 */
function C($key, $value = null)
{
    static $_config = [];
    $args = func_num_args();
    if ($args == 1) {
        if (is_string($key)) { //如果传入的key是字符串
            return isset($_config[$key]) ? $_config[$key] : null;
        }
        if (is_array($key)) {
            if (array_keys($key) !== range(0, count($key) - 1)) {
                $_config = array_merge($_config, $key); //如果传入的key是关联数组,则为赋值
            } else {
                $ret = []; //如果key为索引数组,则为取值
                foreach ($key as $k) {
                    $ret[$k] = isset($_config[$k]) ? $_config[$k] : null;
                }
                return $ret;
            }
        }
    } else {
        if (is_string($key)) {
            $_config[$key] = $value;
        }
    }
    return null;
}

/**
 * 实例化数据库操作类
 * @param string $table
 * @return DB
 */
function D($table = '')
{
    static $db = null;
    if (!($db instanceof DB)) {
        $db = new DB;
    }
    if ($table) {
        $db->table($table);
    }
    return $db;
}

/**
 * 日志记录函数
 * @param $var
 */
function L($var)
{
    $message = date('Y-m-d H:i:s') . PHP_EOL;
    $message .= var_export($var, true) . PHP_EOL;
    $message .= "\n";
    if (!is_dir(RUNTIME_LOG_DIR)) {
        mkdir(RUNTIME_LOG_DIR, 0777, true); //创建日志文件夹
    }
    $logFile = RUNTIME_LOG_DIR . 'debug.log';
    error_log($message, 3, $logFile);
}

/**
 * URL替换
 * @param string $url
 * @return string
 */
function url_replace($url)
{
    //根据路由映射生成URL
    static $routeMap = null;
    if (is_null($routeMap)) {
        $routeMap = C('URL_ROUTE_MAP');
    }

    if ($routeMap && in_array($url, $routeMap)) {
        return array_search($url, $routeMap);
    }

    //根据路由反转规则生成URL
    static $routeRules = null;
    if (is_null($routeRules)) {
        $routeRules = C('URL_ROUTE_FLIP_RULES');
    }

    if ($routeRules) {
        foreach ($routeRules as $key => $val) {
            if (preg_match($key, $url)) {
                return preg_replace($key, $val, $url);
            }
        }
    }
    return $url;
}

/**
 * 生成URL
 * @return string
 */
function url()
{
    $url = func_num_args() ? implode('-', func_get_args()) : '/';
    if ($url === '/') {
        return BASE_URL;
    }
    if (C('URL_ROUTER_ON')) {
        $url = url_replace($url);
    }
    return BASE_URL . $url . C('URL_EXTENSION');
}

/**
 * 获取资源绝对路径
 * @param $file
 * @param string $version
 * @return string
 */
function src($file, $version = '')
{
    if ($version) {
        $file .= '?v=' . $version;
    }
    return BASE_URL . 'static/' . $file;
}

function js($filename, $version = '')
{
    $ext = 'min.js';
    if (DEBUG) {
        $ext = 'js';
        $version = time();
    }
    $file = $filename . '.' . $ext;
    echo src($file, $version);
}

function css($filename, $version = '')
{
    $ext = 'min.css';
    if (DEBUG) {
        $ext = 'css';
        $version = time();
    }
    $file = $filename . '.' . $ext;
    echo src($file, $version);
}

/**
 * 获取GET参数
 * @param string $key 数组健名
 * @param string $default 默认值
 * @return array|string
 */
function get($key = '', $default = '')
{
    if (empty($key)) {
        return array_map('htmlspecialchars', array_map('trim', $_GET));
    }
    return (isset($_GET[$key]) && is_string($_GET[$key])) ? htmlspecialchars(trim($_GET[$key])) : $default;
}

/**
 * 获取POST参数
 * @param string $key 数组健名
 * @param string $default 默认值
 * @return array|string
 */
function post($key = '', $default = '')
{
    if (empty($key)) {
        return array_map('htmlspecialchars', array_map('trim', $_POST));
    }
    return isset($_POST[$key]) ? htmlspecialchars(trim($_POST[$key])) : $default;
}

/**
 * 获取SESSION参数
 * @param string $key 数组健名
 * @param string $default 默认值
 * @return array|null|string
 */
function session($key = '', $default = '')
{
    if (empty($key)) {
        return array_map('trim', $_SESSION);
    }
    return isset($_SESSION[$key]) ? trim($_SESSION[$key]) : $default;
}