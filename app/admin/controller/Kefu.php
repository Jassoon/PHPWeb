<?php

namespace app\admin\controller;

use \core\lib\Pagination;

class Kefu extends Base
{
    const TABLE = 'kefu';

    function indexAction()
    {
        $this->assign('title', '客服列表_在线客服');
        $db = D(self::TABLE);
        $pagination = new Pagination($db->getCount());
        $rows = $db->select("ORDER BY `orderly` ASC {$pagination->limit}");
        $this->assign([
            'rows' => $rows,
            'paging' => $pagination->output('info,prev,item,next')
        ]);
        $this->display();
    }

    function batchAction($type = '')
    {
        $this->batch($type);
        $db = D(self::TABLE);
        if ($type == 'sort') {
            $orderly = array_intersect_key($_POST['orderly'], $_POST['id']);
            foreach ($orderly as $key => $value) {
                $db->update(['id' => $key, 'orderly' => $value]);
            }
            $this->ajaxReturn(1, '操作成功');
        } else if ($type == 'del') {
            $idStr = implode(',', $_POST['id']);
            $db->delete("WHERE `id` IN($idStr)") ? $this->ajaxReturn(1, '操作成功') : $this->ajaxReturn(0, '操作失败');
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
        $this->assign('title', '添加客服_在线客服');
        $this->display();
    }

    function insertAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        if (D(self::TABLE)->insert($_POST)) {
            jump('添加成功', CONTROLLER_URL);
        } else {
            alert('添加失败');
        }
    }

    function editAction($id = 0)
    {
        $this->assign('title', '编辑客服_在线客服');
        $db = D(self::TABLE);
        $data = $db->fetch(intval($id));

        //上下文
        $or = $data['orderly'];
        $prev = $db->fetch("WHERE `orderly` < $or ORDER BY `orderly` DESC", 'id');
        $next = $db->fetch("WHERE `orderly` > $or ORDER BY `orderly` ASC", 'id');

        $this->assign(compact('data', 'prev', 'next'));
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        $_POST['is_show'] = post('is_show', 0);
        $result = D(self::TABLE)->update($_POST);
        if ($result !== false) {
            jump('更新成功', -2);
        } else {
            alert('更新失败');
        }
    }

    function ajaxAction($type = 'show', $id = 0)
    {
        $this->method(IS_AJAX);
        $this->param($id && is_numeric($id) && $type == 'show');
        $data = ['id' => $id];
        $data['is_show'] = get('val');
        if (D(self::TABLE)->update($data)) {
            $this->ajaxReturn(1, '更新成功');
        } else {
            $this->ajaxReturn(0, '更新失败');
        }
    }

}