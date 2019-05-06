<?php

namespace app\admin\controller;

use \core\lib\Pagination;
use \core\lib\FileUpload;

class Image extends Base
{
    const TABLE = 'image';

    function indexAction()
    {
        $this->assign('title', '图片列表_图片管理');
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
            $where = 'WHERE ' . implode($search, ' AND ');
        } else {
            $where = 'WHERE 1';
        }

        $db = D(self::TABLE);
        $pagination = new Pagination($db->getCount($where));
        $rows = $db->select("{$where} ORDER BY `cat` ASC, `orderly` ASC {$pagination->limit}");
        $this->assign([
            'rows' => $rows,
            'paging' => $pagination->output('info,prev,item,next')
        ]);

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
        if (D(self::TABLE)->delete($id)) {
            $this->success('删除成功');
        } else {
            $this->failure('删除失败');
        }
    }

    function addAction()
    {
        $this->assign('title', '添加图片_图片管理');
        $this->display();
    }

    function insertAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        D(self::TABLE)->insert($_POST) ? jump('添加成功', CONTROLLER_URL) : alert('添加失败');
    }

    function editAction($id = 0)
    {
        $this->assign('title', '编辑图片_图片管理');
        $db = D(self::TABLE);
        $data = $db->fetch(intval($id));

        $or = $data['orderly'];
        $prev = $db->fetch("WHERE `orderly` < $or ORDER BY `cat` ASC, `orderly` DESC", 'id');
        $next = $db->fetch("WHERE `orderly` > $or ORDER BY `cat` ASC, `orderly` ASC", 'id');

        $this->assign(compact('data', 'prev', 'next'));
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        $_POST['is_show'] = post('is_show', 0);
        $result = D(self::TABLE)->update($_POST);
        if ($result === false) {
            alert('更新失败');
        } else {
            jump('更新成功', -2);
        }
    }

    function ajaxAction($type = 'show', $id = 0)
    {
        $this->method(IS_AJAX);
        $this->param($id && is_numeric($id) && $type == 'show');
        $data = ['id' => $id, 'is_show' => get('val')];
        if (D(self::TABLE)->update($data)) {
            $this->ajaxReturn(1, '更新成功');
        } else {
            $this->ajaxReturn(0, '更新失败');
        }
    }

    function uploadAction()
    {
        $fu = new FileUpload('image');
        $file = $fu->upload();
        $file ? $this->ajaxReturn(1, '上传成功', $file) : $this->ajaxReturn(0, $fu->error());
    }

}