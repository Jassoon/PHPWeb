<?php

namespace app\admin\controller;

use \core\lib\Pack;

class Backup extends Base
{
    const BACKUP_FILE_DIR = 'backup/file/';
    const BACKUP_SQL_DIR = 'backup/sql/';

    function indexAction($type = 'sql')
    {
        if ($type == 'sql') {
            $this->assign('title', '数据库备份_数据备份');
            $files = glob(self::BACKUP_SQL_DIR . '*.zip');
        } else {
            $this->assign('title', '附件备份_数据备份');
            $files = glob(self::BACKUP_FILE_DIR . '*.zip');
        }
        if ($files === false) {
            $files = [];
        }
        rsort($files);
        $this->assign('type', $type);
        $this->assign('files', $files);
        $this->display();
    }

    // 创建备份
    function createAction($type = 'file')
    {
        set_time_limit(0);
        if ($type == 'sql') {
            $file = self::BACKUP_SQL_DIR . SITE_TOKEN . '_sql_' . date('Ymd_His') . '.zip';
            $db = new \app\admin\model\Backup();
            $db->run($file);
        } else {
            $file = self::BACKUP_FILE_DIR . SITE_TOKEN . '_file_' . date('Ymd_His') . '.zip';
            $pack = new Pack('./upload', $file);
            if ($pack->error) {
                $this->ajaxReturn(0, $pack->error);
            }
        }
        $this->ajaxReturn(1, '备份成功');
    }

    // 删除备份
    function delAction()
    {
        $filename = get('file');
        $this->param($filename);
        $dir = strpos($filename, '_sql_') ? self::BACKUP_SQL_DIR : self::BACKUP_FILE_DIR;
        $file = $dir . $filename;
        if (is_file($file) && unlink($file)) {
            $this->success('删除成功');
        } else {
            $this->failure('删除失败');
        }
    }

    // 下载
    function downAction()
    {
        $filename = filter_input(INPUT_GET, 'file');
        if (strpos($filename, '_sql_')) {
            $file = self::BACKUP_SQL_DIR . $filename;
        } else {
            $file = self::BACKUP_FILE_DIR . $filename;
        }

        if (!is_file($file)) {
            $this->error('文件不存在');
        }

        header('Content-type:application/octet-stream');
        header('Content-Disposition:attachment; filename=' . $filename);
        header('Content-Length:' . filesize($file));
        readfile($file);
    }

}