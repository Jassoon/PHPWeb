<?php

namespace app\admin\controller;

use \core\lib\Pagination;
use \core\lib\FileUpload;

class File extends Base
{
    const TABLE = 'file';

    function indexAction()
    {
        $this->assign('title', '文件列表_文件管理');
        $t1 = DB_TABLE_PRE . 'file';
        $t2 = DB_TABLE_PRE . 'file_category';
        $sql = "SELECT {$t1}.*, {$t2}.cat_name FROM {$t1} LEFT JOIN {$t2} ON {$t1}.cat={$t2}.id ";

        $search = [];
        $cat = get('cat');
        if ($cat && is_numeric($cat)) {
            $search[] = "`cat`={$cat}";
        }

        $title = get('title');
        if ($title) {
            $search[] = "`title` LIKE '%{$title}%'";
        }

        if ($search) {
            $sql .= 'WHERE ' . implode($search, ' AND ');
        }

        $db = D();
        $setting = setting();
        $total = count($db->query($sql)->fetchAll());
        $pagination = new Pagination($total, $setting['file_count']);
        $rows = $db->query("$sql ORDER BY `orderly` {$setting['file_order']} {$pagination->limit}")->fetchAll();

        $this->assign([
            'rows' => $rows,
            'paging' => $pagination->output('info,prev,item,next')
        ]);
        $this->common();
        $this->display();
    }

    function batchAction($type = '', $cat = 0)
    {
        $this->batch($type);
        $db = D(self::TABLE);
        $idStr = implode(',', $_POST['id']);
        if ($type == 'sort') {
            $orderly = array_intersect_key($_POST['orderly'], $_POST['id']);
            foreach ($orderly as $key => $value) {
                $db->update(['id' => $key, 'orderly' => $value]);
            }
            $this->ajaxReturn(1, '操作成功');
        } else if ($type == 'del') {
            $db->delete("WHERE `id` IN($idStr)") ? $this->ajaxReturn(1, '操作成功') : $this->ajaxReturn(0, '操作失败');
        } else if ($type == 'move' && $cat) {
            $result = $db->update(['cat' => $cat], "`id` IN($idStr)");
            ($result !== false) ? $this->ajaxReturn(1, '操作成功') : $this->ajaxReturn(0, '操作失败');
        }
    }

    function delAction($id = 0)
    {
        $this->param($id && is_numeric($id));
        D(self::TABLE)->delete($id) ? $this->success('删除成功') : $this->failure('删除失败');
    }

    function addAction()
    {
        $this->assign('title', '添加文件_文件管理');
        $this->common();
        $this->display();
    }

    function insertAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        if (preg_match('/^upload\//', $_POST['file'])) {
            $_POST['size'] = filesize($_POST['file']);
        }
        D(self::TABLE)->insert($_POST) ? jump('添加成功', CONTROLLER_URL) : alert('添加失败');
    }

    function editAction($id = 0)
    {
        $this->assign('title', '编辑文件_文件管理');
        $db = D(self::TABLE);
        $data = $db->fetch(intval($id));

        //上下文
        $or = $data['orderly'];
        $up = $db->fetch("WHERE `orderly` > $or ORDER BY `orderly` ASC", 'id');
        $down = $db->fetch("WHERE `orderly` < $or ORDER BY `orderly` DESC", 'id');
        if (setting('file_order') == 'DESC') {
            $prev = $up;
            $next = $down;
        } else {
            $prev = $down;
            $next = $up;
        }

        $this->assign(compact('data', 'prev', 'next'));
        $this->common();
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        if (preg_match('/^upload\//', $_POST['file'])) {
            $_POST['size'] = filesize($_POST['file']);
        } else {
            $_POST['size'] = 0;
        }
        $_POST['is_tj'] = post('is_tj', 0);
        $_POST['is_show'] = post('is_show', 0);
        $result = D(self::TABLE)->update($_POST);
        if ($result === false) {
            alert('更新失败');
        } else {
            jump('更新成功', -2);
        }
    }

    function uploadAction()
    {
        $fu = new FileUpload('file');
        $fu->types = ['rar', 'zip', '7z', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'];
        $file = $fu->upload();
        if (!$file) {
            $this->ajaxReturn(0, $fu->error());
        }
        $this->ajaxReturn(1, '上传成功', $file);
    }

    function ajaxAction($type = 'show', $id = 0)
    {
        $this->method(IS_AJAX);
        $this->param($id && is_numeric($id));
        $data = ['id' => $id];
        if ($type == 'show') {
            $data['is_show'] = get('val');
        } else {
            $data['is_tj'] = get('val');
        }
        if (D(self::TABLE)->update($data)) {
            $this->ajaxReturn(1, '更新成功');
        } else {
            $this->ajaxReturn(0, '更新失败');
        }
    }

    private function common()
    {
        $this->category = D('file_category')->select('ORDER BY `orderly` ASC');
    }

}