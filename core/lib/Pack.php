<?php
/**
 * Class Pack
 * @package core\lib
 */

namespace core\lib;

use ZipArchive;

class Pack
{
    public $error = '';
    private $zip = null;

    function __construct($folder, $zipFile)
    {
        if (!is_dir($folder)) {
            $this->error = '文件夹路径错误';
            return;
        }

        $zipDir = pathinfo($zipFile, PATHINFO_DIRNAME);
        if (!is_dir($zipDir)) {
            mkdir($zipDir, 0777, true);
        }

        $this->zip = new ZipArchive();
        $this->zip->open($zipFile, ZipArchive::CREATE);
        $this->addDir($folder, pathinfo($folder, PATHINFO_FILENAME));
        $this->zip->close();
    }

    /**
     * 添加文件夹
     * @param string $folder 文件夹
     * @param string $localDir zip中的文件夹
     */
    function addDir($folder, $localDir)
    {
        if (is_dir($folder) && $handle = opendir($folder)) {
            while ($file = readdir($handle)) {
                if ($file === false || $file == '.' || $file == '..') {
                    continue;
                }
                $fileName = $folder . '/' . $file;
                $localName = $localDir . '/' . $file;
                if (is_file($fileName)) {
                    $this->zip->addFile($fileName, $localName);
                } else {
                    $this->addDir($fileName, $localName);
                }
            }
        }
    }

}