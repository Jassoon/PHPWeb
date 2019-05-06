<?php

namespace app\admin\controller;

use \core\lib\Pagination;

class Message extends Base
{
    const TABLE = 'message';

    function indexAction()
    {
        $this->assign('title', '留言列表_留言管理');
        $search = [];
        $where = 'WHERE 1';

        $type = get('type');
        if (is_numeric($type)) {
            $search[] = "`type`={$type}";
        }

        $key = get('key');
        if ($key) {
            $search[] = "`content` LIKE '%{$key}%'";
        }

        if ($search) {
            $where = 'WHERE ' . implode($search, ' AND ');
        }

        $db = D(self::TABLE);
        $pagination = new Pagination($db->getCount($where));
        $rows = $db->select("{$where} ORDER BY `id` DESC {$pagination->limit}");
        $this->assign([
            'rows' => $rows,
            'paging' => $pagination->output('info,prev,item,next')
        ]);
        $this->display();
    }

    function batchAction($type = '')
    {
        $this->batch($type);
        if ($type == 'del') {
            $db = D(self::TABLE);
            $idStr = implode(',', $_POST['id']);
            $db->delete("WHERE `id` IN($idStr)") ? $this->ajaxReturn(1, '操作成功') : $this->ajaxReturn(0, '操作失败');
        }
    }

    function delAction($id = 0)
    {
        $this->param($id && is_numeric($id));
        D(self::TABLE)->delete($id) ? $this->success('删除成功') : $this->failure('删除失败');
    }

    function itemAction($id = 0)
    {
        $this->assign('title', '查看留言_留言管理');
        $db = D(self::TABLE);
        $id = intval($id);
        $data = $db->fetch($id);
        $prev = $db->fetch("WHERE id > $id ORDER BY `id` ASC", 'id, is_read'); //上一条
        $next = $db->fetch("WHERE id < $id ORDER BY `id` DESC", 'id, is_read'); //下一条

        //更新为已读
        if (!$data['is_read']) {
            $db->update(['id' => $id, 'is_read' => 1]);
        }

        $this->assign(compact('data', 'prev', 'next'));
        $this->display();
    }

}