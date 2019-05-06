<?php

namespace app\admin\controller;

use \core\lib\Pagination;

class Page extends Base
{
    const TABLE = 'page';

    function indexAction()
    {
        $this->assign('title', '页面列表_页面管理');
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
        $rows = $db->select("{$where} ORDER BY `cat` ASC, `id` ASC {$pagination->limit}", 'id, cat, title');
        $this->assign([
            'rows' => $rows,
            'paging' => $pagination->output('info,prev,item,next')
        ]);
        $this->display();
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
        $this->assign('title', '添加页面_页面管理');
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
        $this->assign('title', '编辑页面_页面管理');
        $id = intval($id);
        $db = D(self::TABLE);
        $data = $db->fetch($id);
        $prev = $db->fetch("WHERE id < $id ORDER BY `cat` ASC, `id` DESC", 'id'); //上一条
        $next = $db->fetch("WHERE id > $id ORDER BY `cat` ASC, `id` ASC", 'id'); //下一条

        $this->assign(compact('data', 'prev', 'next'));
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        if (D(self::TABLE)->update($_POST) === false) {
            alert('更新失败');
        }
        jump('更新成功', -2);
    }

}