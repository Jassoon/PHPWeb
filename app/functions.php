<?php

use core\lib\Cache;

/**
 * 页面跳转+Cookie提示
 * @param string $message 提示消息
 * @param string||int $location 跳转地址
 */
function jump($message, $location = -1)
{
    setcookie('serverMessage', $message, 0, BASE_URL);
    if (is_int($location)) {
        if ($location == -1 && isset($_SERVER['HTTP_REFERER'])) {
            header('Location:' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "<script> window.history.go({$location}); </script>";
        }
    } else {
        if (headers_sent()) {
            echo "<script>window.location.replace('{$location}');</script>";
        } else {
            header('Location:' . $location);
        }
    }
    exit;
}

/**
 * 页面跳转+JS提示
 * @param string $message 提示消息
 * @param string $location 跳转地址
 */
function alert($message, $location = -1)
{
    header('Content-Type:text/html;charset=utf-8');
    echo '<script>';
    echo " alert('{$message}'); "; //提示
    if (is_int($location)) {
        echo "window.history.go({$location}); "; //返回
    } else {
        echo "window.location.replace('{$location}'); "; //跳转到指定页面
    }
    echo '</script >';
    exit;
}

/**
 * 截取字符串（支持中英文）
 * @param string $string 需要截取的字符串
 * @param int $length 取多少个字符
 * @return string
 */
function usubstr($string, $length)
{
    if (mb_strlen($string, 'utf-8') <= $length) {
        return $string;
    } else {
        return mb_substr($string, 0, $length, 'utf-8') . ' ...';
    }
}

/**
 * 使用适合阅读的格式显示文件大小
 * @param int $size 用于计算的文件大小
 * @param int $precision 小数点后数字的数目
 * @return string
 */
function file_size($size, $precision = 2)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $size >= 1024; $i++) {
        $size /= 1024;
    }
    return round($size, $precision) . ' ' . $units[$i];
}

/**
 * 文件下载
 * @param string $file 下载文件路径
 * @param string $name 下载时显示的文件名称(不含扩展名)
 */
function download($file, $name)
{
    $filename = $name . '.' . pathinfo($file, PATHINFO_EXTENSION);

    //解决IE中文乱码的问题
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
        $filename = urlencode($filename);
    }
    header("Content-type:application/octet-stream");
    header("Content-Disposition:attachment; filename={$filename}");
    readfile($file);
    exit;
}

/**
 * 检测页面是否为微信浏览器请求
 * @return bool
 */
function is_weixin()
{
    return !(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false);
}

/**
 * @param string $key
 * @param string $default
 * @return array|bool|string
 */
function setting($key = '', $default = '')
{
    static $setting = [];
    if (empty($setting)) {
        $setting = get_setting();
    }
    if (empty($key)) {
        return $setting;
    } else {
        return array_key_exists($key, $setting) ? $setting[$key] : $default;
    }
}

function get_setting()
{
    $setting = Cache::read('setting');
    if (is_bool($setting)) {
        $result = D('setting')->select();
        $setting = [];
        foreach ($result as $row) {
            $setting[$row['setting_key']] = $row['setting_val'];
        }
        Cache::write('setting', $setting);
    }
    return $setting;
}

function base64_to_image($base64, $path)
{
    if (preg_match('/^(data:\s*image\/(\w+);base64,)[\s\S]+/', $base64, $matches)) {
        $file = $path . md5($base64) . '.' . $matches[2];
        $result = file_put_contents($file, base64_decode(str_replace($matches[1], '', $base64)));
        return $result ? $file : '';
    }
    return '';
}

/**
 * 输出下拉列表
 * @param resource $data 用于循环的数据资源
 * @param  string $value 下拉列表值字段
 * @param string $text 下拉列表文本字段
 * @param  string $default 默认选中项
 */
function option($data, $value, $text, $default = '')
{
    foreach ($data as $row) {
        if (strval($default) == strval($row[$value])) {
            $format = '<option value="%s" selected="selected">%s</option>';
        } else {
            $format = '<option value="%s">%s</option>';
        }
        printf($format, $row[$value], $row[$text]);
    }
}

/**
 * 输出单选框
 * @param string $name 单选框的名称
 * @param string $value 单选框的值
 * @param string $checked 用于判断是否选中的值
 */
function radio($name, $value, $checked)
{
    $format = ($checked === $value) ? '<input name="%s" type="radio" value="%s" checked />' : '<input name="%s" type="radio" value="%s" />';
    printf($format, $name, $value);
}

/**
 * 输出复选框
 * @param string $name 复选框的名称
 * @param string $value 复选框的值
 * @param string $checked 用于判断是否选中的值
 */
function checkbox($name, $value, $checked)
{
    $format = ($checked === $value) ? '<input name="%s" type="checkbox" value="%s" checked />' : '<input name="%s" type="checkbox" value="%s" />';
    printf($format, $name, $value);
}