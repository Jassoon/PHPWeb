<?php

namespace app\admin\controller;

use core\lib\Tree;

class ProductCategory extends Base
{
    const TABLE = 'product_category';

    function indexAction()
    {
        $this->assign('title', '类别列表_产品类别');
        $pid = get('pid', 0);
        $rows = D(self::TABLE)->select('ORDER BY `orderly` ASC', 'id, pid, path, cat_name, orderly');
        $tree = new Tree($rows);
        $path = $tree->getPath($pid);
        $nodes = $tree->children($pid);
        $this->assign(compact('pid', 'tree', 'path', 'nodes'));
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
        } else {
            $this->error();
        }
    }

    function delAction($id = 0)
    {
        $this->param($id && is_numeric($id));
        $db = D(self::TABLE);
        $data = $db->fetch($id);

        // 检查当前类别下是否存在子类
        $path = $data['path'] . '-' . $data['id'];
        $children = $db->select("WHERE `path` LIKE '{$path}%'");
        if ($children) {
            $this->failure('当前类别存在子类,禁止删除');
        }

        // 检查当前类别下是否存在关联内容
        $sum = $db->table('product')->getCount("WHERE `cat`={$id}");
        if ($sum) {
            $this->failure('类别存在内容,禁止删除');
        }

        // 删除类别
        if ($db->table(self::TABLE)->delete($id)) {
            $this->success('删除成功');
        } else {
            $this->failure('删除失败');
        }
    }

    function addAction()
    {
        $this->assign('title', '添加类别_产品类别');
        $category = D(self::TABLE)->select('ORDER BY `orderly` ASC');
        $tree = new Tree($category);
        $this->assign(compact('tree'));
        $this->display();
    }

    function insertAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        $db = D(self::TABLE);
        $pid = $_POST['pid'];

        // 生成path
        if ($pid) {
            $path = [];
            $parent = $db->fetch($pid);
            if ($parent['path']) {
                $path[] = $parent['path'];
            }
            $path[] = $parent['id'];
            $_POST['path'] = implode('-', $path);
        }

        // 插入数据
        if ($db->insert($_POST)) {
            jump('添加成功', "ProductCategory?pid={$pid}");
        } else {
            alert('添加失败');
        }
    }

    function editAction($id = 0)
    {
        $this->assign('title', '编辑类别_产品类别');
        $db = D(self::TABLE);
        $data = $db->fetch(intval($id));

        $pid = $data['pid'];
        $or = $data['orderly'];
        $prev = $db->fetch("WHERE `pid`={$pid} AND `orderly` < {$or} ORDER BY `orderly` DESC", 'id'); //上一条
        $next = $db->fetch("WHERE `pid`={$pid} AND `orderly` > {$or} ORDER BY `orderly` ASC", 'id'); //下一条

        $category = $db->select("WHERE `id`!={$data['id']} ORDER BY `orderly` ASC");
        $tree = new Tree($category);

        $this->assign(compact('data', 'prev', 'next', 'tree'));
        $this->display();
    }

    function updateAction()
    {
        $this->method(IS_POST);
        $this->param(isset($_POST['submit']));
        $db = D(self::TABLE);
        $pid = $_POST['pid'];

        // 生成path
        $path = [];
        if ($pid) {
            $parent = $db->fetch($pid);
            if ($parent['path']) {
                $path[] = $parent['path'];
            }
            $path[] = $parent['id'];
        }
        $_POST['path'] = implode('-', $path);

        $result = $db->update($_POST);
        ($result === false) ? alert('更新失败') : jump('更新成功', "ProductCategory?pid={$pid}");
    }

}