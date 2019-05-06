<?php
/**
 * Class Cache
 * @package core\lib
 */

namespace core\lib;

class Cache
{

    /**
     * 读取缓存
     * @param string $name 缓存文件名
     * @return array|boolean 如果缓存文件存在内则返回数组，否则返回假
     */
    static function read($name)
    {
        $file = RUNTIME_DATA_DIR . md5($name) . '.php';
        if (is_file($file)) {
            $content = file_get_contents($file);
            $json = substr($content, 8);
            return json_decode($json, true);
        } else {
            return false;
        }
    }

    /**
     * 写入缓存
     * @param string $name 缓存文件名
     * @param array $data 需要缓存的数据
     */
    static function write($name, $data)
    {
        $file = RUNTIME_DATA_DIR . md5($name) . '.php';
        if (!is_dir(RUNTIME_DATA_DIR)) {
            mkdir(RUNTIME_DATA_DIR, 0777, true);
        }
        $json = json_encode($data);
        $content = '<?php # ' . $json;
        file_put_contents($file, $content);
    }

    /**
     * 删除缓存
     * @param string $name 缓存文件名
     */
    static function delete($name)
    {
        $file = RUNTIME_DATA_DIR . md5($name) . '.php';
        if (is_file($file)) {
            unlink($file);
        }
    }

}