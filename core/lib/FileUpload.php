<?php
/**
 * Class FileUpload
 * @package core\lib
 */

namespace core\lib;

class FileUpload
{
    public
        $path, // 文件保存路径
        $types = ['jpg', 'png', 'gif'], // 允许上传的文件类型
        $namingRules = 'md5'; //命名规则 md5||time

    private
        $error; //错误信息

    /**
     * 构造函数
     * @param string $dir 文件保存目录
     */
    function __construct($dir)
    {
        $this->path = 'upload/' . $dir . '/';
    }

    /**
     * 文件上传函数
     * @param array $file 文件上传信息
     * @return bool
     */
    function upload(array $file = [])
    {
        $file = empty($file) ? array_shift($_FILES) : $file;

        //错误信息提示
        switch ($file['error']) {
            case 1:
                $this->error = '文件大小不能超过' . ini_get('upload_max_filesize');
                break;
            case 2:
                $this->error = '文件大小不能超过' . ($_POST['MAX_FILE_SIZE'] / 1048576) . 'M';
                break;
            case 3:
                $this->error = '文件只有部分被上传';
                break;
            case 4:
                $this->error = '没有文件被上传';
                break;
            case 6:
                $this->error = '找不到临时文件夹';
                break;
            case 7:
                $this->error = '文件写入失败';
                break;
        }
        if ($this->error) {
            return false;
        }

        //获取文件扩展名
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        //检查文件类型
        if (!in_array($extension, $this->types)) {
            $this->error = '文件格式错误，允许上传的文件格式为 ' . implode(',', $this->types);
            return false;
        }

        //检查上传目录是否存在,如果不存在则新建目录
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }

        //文件重命名
        $name = ($this->namingRules == 'md5') ? md5_file($file['tmp_name']) : (time() . rand(10, 99));
        $destination = $this->path . $name . '.' . $extension;

        //移动文件
        $result = move_uploaded_file($file['tmp_name'], $destination);
        if (!$result) {
            $this->error = '文件移动失败';
            return false;
        }
        return $destination;
    }

    /**
     * @param array $files
     * @param int $i 文件索引
     * @return bool
     */
    function uploads($files, $i)
    {
        $file['name'] = $files['name'][$i];
        $file['type'] = $files['type'][$i];
        $file['tmp_name'] = $files['tmp_name'][$i];
        $file['error'] = $files['error'][$i];
        $file['size'] = $files['size'][$i];
        return $this->upload($file);
    }

    /**
     * 获取错误信息
     */
    function error()
    {
        return $this->error;
    }

}