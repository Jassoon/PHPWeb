<?php
// core
define('CORE_DIR', __DIR__ . DIRECTORY_SEPARATOR); //框架目录
define('CORE_LIB_DIR', CORE_DIR . 'lib' . DIRECTORY_SEPARATOR); //框架类库目录
define('CORE_TPL_DIR', CORE_DIR . 'tpl' . DIRECTORY_SEPARATOR); //框架模板目录

// app
define('APP_DIR', ROOT_DIR . 'app' . DIRECTORY_SEPARATOR); //应用目录
define('MODULE_DIR', APP_DIR . MODULE . DIRECTORY_SEPARATOR); //模块目录
define('CONTROLLER_DIR', MODULE_DIR . 'controller' . DIRECTORY_SEPARATOR); //控制器目录
define('MODEL_DIR', MODULE_DIR . 'model' . DIRECTORY_SEPARATOR); //模型目录
define('VIEW_DIR', MODULE_DIR . 'view' . DIRECTORY_SEPARATOR); //视图目录

// runtime
define('RUNTIME_DIR', ROOT_DIR . 'runtime' . DIRECTORY_SEPARATOR); //系统运行时缓存目录
define('RUNTIME_FIELD_DIR', RUNTIME_DIR . 'field' . DIRECTORY_SEPARATOR); //字段缓存目录
define('RUNTIME_DATA_DIR', RUNTIME_DIR . 'data' . DIRECTORY_SEPARATOR); //数据缓存目录
define('RUNTIME_LOG_DIR', RUNTIME_DIR . 'log' . DIRECTORY_SEPARATOR); //错误日志目录

//项目根路径
if (!defined('BASE_URL')) {
    $sn = dirname($_SERVER['SCRIPT_NAME']);
    define('BASE_URL', ($sn == '\\' || $sn == '/') ? '/' : ($sn . '/'));
}

/* 加载函数文件 */
require(CORE_DIR . 'functions.php'); //框架函数文件
import(APP_DIR . 'functions.php'); //应用函数文件
import(MODULE_DIR . 'functions.php'); //模块函数文件

/* 加载配置文件 */
load_config(CORE_DIR . 'config.php'); //框架配置文件
load_config(APP_DIR . 'config.php'); //应用配置文件
load_config(MODULE_DIR . 'config.php'); //模块配置文件

// 启动框架
include(CORE_LIB_DIR . 'Main.php');
core\lib\Main::getInstance();