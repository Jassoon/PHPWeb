<?php
/**
 * Class Router
 * @package core\lib
 */

namespace core\lib;

class Router
{

    //解析URL
    static function parse()
    {
        // 获取请求类型
        define('IS_GET', $_SERVER['REQUEST_METHOD'] == 'GET');
        define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST');
        define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');

        $origPathInfo = '';
        if (!empty($_SERVER['PATH_INFO'])) {
            $origPathInfo = $_SERVER['PATH_INFO'];
        } else if (isset($_SERVER['ORIG_PATH_INFO'])) {
            $origPathInfo = $_SERVER['ORIG_PATH_INFO'];
        } else if (isset($_GET['_path_'])) {
            $origPathInfo = (string)filter_input(INPUT_GET, '_path_');
            unset($_GET['_path_']);
        }

        // 默认值
        $pathInfo = '';
        $controller = 'Index';
        $action = 'index';
        $arguments = []; //参数
        $extension = ''; //扩展名

        //PathInfo 验证
        if ($origPathInfo && preg_match('/^\/([a-zA-Z0-9-]+)(.([a-z]{3,4}))?$/', $origPathInfo, $matches)) {
            $pathInfo = $matches[1];
            if (isset($matches[3])) {
                $extension = $matches[3];
            }
        }

        // PathInfo 解析
        if ($pathInfo) {
            if (C('URL_ROUTER_ON')) {
                $pathInfo = static::route($pathInfo); //路由替换
            }
            $paths = explode('-', $pathInfo);
            if (!empty($paths)) {
                $controller = array_shift($paths);
            }
            if (!empty($paths)) {
                $action = array_shift($paths);
            }
            if (!empty($paths)) {
                $arguments = $paths;
            }
        }

        define('CONTROLLER', ucfirst($controller));
        define('ACTION', strtolower($action));
        define('EXTENSION', strtolower($extension));

        /* URL常量定义 */
        define('CONTROLLER_URL', BASE_URL . CONTROLLER); //当前controller路径
        define('ACTION_URL', $_SERVER['PHP_SELF']); //当前action路径
        define('SELF_URL', $_SERVER['REQUEST_URI']); //当前URL路径

        return $arguments;
    }

    // 路由处理
    static function route($pathInfo)
    {
        $mapRules = C('URL_ROUTE_MAP');
        $routeRules = C('URL_ROUTE_RULES');

        //静态路由替换
        if (is_array($mapRules) && array_key_exists($pathInfo, $mapRules)) {
            return $mapRules[$pathInfo];
        }

        //正则路由替换
        if ($routeRules) {
            foreach ($routeRules as $key => $val) {
                if (preg_match($key, $pathInfo)) {
                    return preg_replace($key, $val, $pathInfo);
                }
            }
        }

        return $pathInfo;
    }

}