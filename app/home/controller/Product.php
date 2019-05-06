<?php

namespace app\home\controller;

use \core\lib\Pagination;

class Product extends Base
{
    const TABLE = 'product';

    //Index
    function indexAction($cat = 0)
    {
        $db = D();
        $setting = setting();
        $tree = $this->getProductCategoryTree();

        $category = [
            'cat_name' => '产品展示',
            'title_bar' => '',
            'description' => '',
            'keywords' => ''
        ];

        //查询
        $where = "WHERE `is_show`='1'";
        if ($cat && is_numeric($cat)) {
            $category = $tree->find($cat);
            if (!$category) {
                $this->_404();
            }
            $incat = $tree->getFamilyId($cat);
            $where .= "AND `cat`IN ({$incat})";
        }

        $total = $db->table(self::TABLE)->getCount($where);
        $pagination = new Pagination($total, $setting['product_count']);
        $rows = $db->select("$where ORDER BY `orderly` {$setting['product_order']} {$pagination->limit}", 'id, name, img1, img2');

        $this->assign([
            'title' => $category['title_bar'] ?: ($category['cat_name'] . '_' . $setting['site_name']),
            'description' => $category['description'],
            'keywords' => $category['keywords'],
            'rows' => $rows,
            'paging' => $pagination->output()
        ]);

        $this->common($cat);
        $this->display();
    }

    //Item
    function itemAction($id = 0)
    {
        if (!($id && is_numeric($id))) {
            $this->_404();
        }

        $db = D();

        //产品数据
        $data = $db->table(self::TABLE)->fetch("WHERE `is_show`='1' AND `id`={$id}");
        if (!$data) {
            $this->_404();
        }

        //上下文
        $cat = $data['cat'];
        $or = $data['orderly'];
        $up = $db->fetch("WHERE `is_show`='1' AND `cat`={$cat} AND `orderly` > $or ORDER BY `orderly` ASC", 'id, name'); //上一条
        $down = $db->fetch("WHERE `is_show`='1' AND `cat`={$cat} AND `orderly` < $or ORDER BY `orderly` DESC", 'id, name'); //下一条
        if (setting('product_order') == 'DESC') {
            $prev = $up;
            $next = $down;
        } else {
            $prev = $down;
            $next = $up;
        }

        $this->assign([
            'title' => $data['title_bar'] ?: ($data['name'] . '_' . setting('site_name')),
            'description' => $data['description'],
            'keywords' => $data['keywords'],
            'data' => $data,
            'attr' => json_decode($data['attr'], true),
            'prev' => $prev,
            'next' => $next
        ]);

        $this->common($data['cat']);
        $this->display();
    }

    //Search
    function searchAction()
    {
        $s = get('s');
        $db = D(self::TABLE);
        $setting = setting();

        $where = "WHERE `is_show`='1' AND `name` LIKE '%{$s}%'";
        $total = $db->getCount($where);
        $pagination = new Pagination($total, $setting['product_count']);
        $rows = $db->select("$where ORDER BY `orderly` {$setting['product_order']} {$pagination->limit}", 'id, name, img2');

        $this->assign([
            'title' => '产品搜索_' . $setting['site_name'],
            'rows' => $rows,
            'paging' => $pagination->output(),
            'path' => '<span class="gt"> &gt;&gt; </span>产品搜索'
        ]);

        $this->display('Product/index');
    }

    function common($cat = '')
    {
        $tree = $this->getProductCategoryTree();
        $path = sprintf('<span class="gt"> &gt;&gt; </span><a href="%s" title="产品展示">产品展示</a>', url('product'));
        if ($cat) {
            $paths = $tree->getPath($cat);
            foreach ($paths as $val) {
                $url = url('product-index', $val['id']);
                $path .= sprintf('<span class="gt"> &gt;&gt; </span><a href="%s" title="%s">%s</a>', $url, $val['cat_name'], $val['cat_name']);
            }
        }
        $this->assign('path', $path);
    }

}