<?php

namespace app\admin\controller;

use \core\lib\Pagination;

class User extends Base
{
    const TABLE = 'user';

    function indexAction()
    {
        $this->assign('title', '用户列表_用户管理');
        $db = D(self::TABLE);
        $pagination = new Pagination($db->getCount());
        $rows = $db->select("ORDER BY `id` ASC {$pagination->limit}", 'id,name,account,login_number,last_login_time,last_login_ip');
        $this->assign([
            'rows' => $rows,
            'paging' => $pagination->output('info,prev,item,next')
        ]);
        $this->display();
    }

    function delAction($id = 0)
    {
        $this->param($id && is_numeric($id));

        if (intval($id) == 1) {
            $this->failure('超级管理员帐号禁止删除');
        }
        D(self::TABLE)->delete($id) ? $this->success('删除成功') : $this->failure('删除失败');
    }

    function addAction()
    {
        $this->assign('title', '添加用户_用户管理');
        $this->display();
    }

    function insertAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        $data = [];
        $data['name'] = trim($_POST['name']);
        $data['account'] = trim($_POST['account']);
        $data['password'] = md5($_POST['password']);
        if (isset($_POST['rights']) && is_array($_POST['rights'])) {
            $data['rights'] = json_encode($_POST['rights']);
        }
        D(self::TABLE)->insert($data) ? $this->ajaxReturn(1, '添加成功') : $this->ajaxReturn(0, '添加失败');
    }

    function editAction($id = 0)
    {
        $this->assign('title', '编辑用户_用户管理');
        $db = D(self::TABLE);
        $data = $db->fetch(intval($id));
        $this->rights = json_decode($data['rights'], true);

        //上下文
        $prev = $db->fetch("WHERE `id` < {$id} ORDER BY `id` DESC", 'id'); //上一条
        $next = $db->fetch("WHERE `id` > {$id} ORDER BY `id` ASC", 'id'); //下一条

        $this->assign(compact('data', 'prev', 'next'));
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        $data = [];
        $data['name'] = trim($_POST['name']);
        $data['account'] = trim($_POST['account']);
        if ($_POST['password']) {
            $data['password'] = md5($_POST['password']);
        }
        $data['rights'] = isset($_POST['rights']) ? json_encode($_POST['rights']) : '';
        $result = D(self::TABLE)->update($data, $_POST['id']);
        ($result !== false) ? $this->ajaxReturn(1, '更新成功') : $this->ajaxReturn(0, '更新失败');
    }

    function checkAction($id = 0)
    {
        $account = get('account');
        if (empty($account)) {
            echo 'false';
            exit;
        }

        $data = [];
        $data[] = "`account`='{$account}'";

        if ($id && is_numeric($id)) {
            $data[] = "`id` != {$id}";
        }

        $where = 'WHERE ' . implode(' AND ', $data);
        $result = D(self::TABLE)->fetch($where);
        echo $result ? 'false' : 'true';
    }

}