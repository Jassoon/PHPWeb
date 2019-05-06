<?php

namespace app\admin\controller;

use \core\lib\Pagination;

class FileCategory extends Base
{
    const TABLE = 'file_category';

    function indexAction()
    {
        $this->assign('title', '类别列表_文件类别');
        $db = D(self::TABLE);
        $pagination = new Pagination($db->getCount());
        $rows = $db->select("ORDER BY `orderly` ASC {$pagination->limit}", 'id, cat_name, orderly');
        $this->assign([
            'rows' => $rows,
            'paging' => $pagination->output('info,prev,item,next')
        ]);
        $this->display();
    }

    function batchAction($type = '')
    {
        $this->batch($type);
        if ($type == 'sort') {
            $db = D(self::TABLE);
            $orderly = array_intersect_key($_POST['orderly'], $_POST['id']);
            foreach ($orderly as $key => $value) {
                $db->update(['id' => $key, 'orderly' => $value]);
            }
            $this->ajaxReturn(1, '操作成功');
        }
    }

    function delAction($id = 0)
    {
        $this->param($id && is_numeric($id));
        $db = D('file');
        $sum = $db->getCount("WHERE `cat`={$id}");
        if ($sum) {
            $this->failure('类别存在内容,禁止删除');
        }
        $db->table(self::TABLE)->delete($id) ? $this->success('删除成功') : $this->failure('删除失败');
    }

    function addAction()
    {
        $this->assign('title', '添加类别_文件类别');
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
        $this->assign('title', '编辑类别_文件类别');
        $db = D(self::TABLE);
        $data = $db->fetch(intval($id));

        //上下文
        $or = $data['orderly'];
        $prev = $db->fetch("WHERE `orderly` < $or ORDER BY `orderly` DESC", 'id'); //上一条
        $next = $db->fetch("WHERE `orderly` > $or ORDER BY `orderly` ASC", 'id'); //下一条

        $this->assign(compact('data', 'prev', 'next'));
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        $result = D(self::TABLE)->update($_POST);
        ($result === false) ? alert('更新失败') : jump('更新成功', -2);
    }

}