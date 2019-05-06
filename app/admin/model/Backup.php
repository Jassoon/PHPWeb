<?php

namespace app\admin\model;

use \core\lib\DB;
use \PDOStatement;
use \ZipArchive;

class Backup extends DB
{

    /**
     * 数据库备份
     * @param string
     */
    function run($file)
    {
        $dir = pathinfo($file, PATHINFO_DIRNAME);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $zip = new ZipArchive();
        $zip->open($file, ZipArchive::CREATE);
        $tables = $this->showTables();
        $sql = $this->export($tables);
        $zip->addFromString(DB_NAME . '.sql', $sql);
        $zip->close();
    }

    /**
     * 查找数据库中指定前缀的数据表
     * @return array
     */
    private function showTables()
    {
        $tables = [];
        $result = $this->query('SHOW TABLES FROM `' . DB_NAME . '`');
        $rows = $result->fetchAll();
        foreach ($rows as $row) {
            $row = array_values($row);
            if (strpos($row[0], DB_TABLE_PRE) === 0) {
                $tables[] = $row[0];
            }
        }
        return $tables;
    }

    /**
     * 导出数据库
     * @param array $tables 数据表名
     * @return string
     */
    private function export(array $tables)
    {
        $sql = "-- Host: " . DB_HOST . "\n";
        $sql .= "-- Generation Time: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- 服务器版本: " . $this->version() . "\n";
        $sql .= "-- PHP Version: " . PHP_VERSION . "\n";
        $sql .= "-- Database: `" . DB_NAME . "`\n";

        foreach ($tables as $table) {
            $sql .= "\n";
            $sql .= "-- `{$table}`\n";
            $result = $this->query("SHOW CREATE TABLE `{$table}`");
            $arr = $result->fetch();
            $sql .= $arr['Create Table'] . ";\n";
            $result = $this->query("SELECT * FROM `{$table}`");
            if ($result instanceof PDOStatement && $rows = $result->fetchAll()) {
                $group = array_chunk($rows, 50);
                foreach ($group as $val) {
                    $list = array_map(function ($v) {
                        $v = array_map('addslashes', $v);
                        $v = str_replace("\r\n", '\r\n', $v);
                        return "('" . implode("', '", $v) . "')";
                    }, $val);
                    $sql .= "\n";
                    $sql .= "INSERT INTO `{$table}` VALUES\n";
                    $sql .= implode(",\n", $list) . ";\n";
                }
            }
        }

        return $sql;
    }

}