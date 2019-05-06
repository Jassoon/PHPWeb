<?php
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    exit('least PHP version 5.5.0');
}

define('DB_HOST', '127.0.0.1'); //数据库服务器地址
define('DB_USER', 'web_upoup_sql'); //数据库用户名
define('DB_PWD', 'Z7AkbxH3PFfkAwwW'); //数据库密码
define('DB_NAME', 'web_upoup_sql'); //数据库名称
define('DB_TABLE_PRE', 'cn_'); //数据表前缀
define('SITE_TOKEN', 'cms'); //站点标记
define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR); //项目根目录
define('DEBUG', true); //Debug

switch ($_SERVER['HTTP_HOST']) {
    case 'web.admin.upoup.com':
        define('MODULE', 'admin');
        break;
    default:
        define('MODULE', 'home');
        break;
}

require(ROOT_DIR . 'core/start.php');