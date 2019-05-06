<?php

namespace app\home\controller;

use \core\lib\Pagination;

class Article extends Base
{
    const TABLE = 'article';

    //Index
    function indexAction($id = '')
    {
        $db = D();
        $setting = setting();
        $id = is_numeric($id) ? $id : '';

        //查询类别名称
        $category = $this->category($id);
        if (!$category) {
            $this->_404();
        }

        //内容查询
        $where = "WHERE `is_show`='1' AND `cat`={$category['id']}";
        $total = $db->table(self::TABLE)->getCount($where);
        $pagination = new Pagination($total, $setting['article_count']);
        $rows = $db->select("$where ORDER BY `orderly` {$setting['article_order']} {$pagination->limit}", 'id, title, create_date');

        $this->assign([
            'title' => $category['title_bar'] ?: ($category['cat_name'] . '_' . $setting['site_name']),
            'description' => $category['description'],
            'keywords' => $category['keywords'],
            'category' => $category,
            'paging' => $pagination->output(),
            'rows' => $rows
        ]);

        $this->display();
    }

    //Item
    function itemAction($id = 0)
    {
        if (!($id && is_numeric($id))) {
            $this->_404();
        }

        $db = D();
        $data = $db->table(self::TABLE)->fetch("WHERE `is_show`='1' AND `id`={$id}");
        if (!$data) {
            $this->_404();
        }

        $setting = setting();
        $title = (empty($data['title_bar'])) ? ($data['title'] . '_' . $setting['site_name']) : ($data['title_bar']);
        $author = empty($data['author']) ? $setting['site_name'] : $data['author'];
        $author_url = empty($data['author_url']) ? $setting['site_url'] : $data['author_url'];
        $this->assign([
            'title' => $title,
            'author' => $author,
            'author_url' => $author_url
        ]);

        //上下文
        $or = $data['orderly'];
        $cat = $data['cat'];
        $up = $db->fetch("WHERE `cat`={$cat} AND `is_show`='1' AND `orderly` > $or ORDER BY `orderly` ASC", 'id, title'); //上一条
        $down = $db->fetch("WHERE `cat`={$cat} AND `is_show`='1' AND `orderly` < $or ORDER BY `orderly` DESC", 'id, title'); //下一条
        if ($setting['article_order'] == 'DESC') {
            $prev = $up;
            $next = $down;
        } else {
            $prev = $down;
            $next = $up;
        }

        $this->assign([
            'category' => $this->category($data['cat']), //类别信息
            'description' => $data['description'],
            'keywords' => $data['keywords'],
            'data' => $data,
            'prev' => $prev,
            'next' => $next
        ]);

        $this->display();
    }

    //Category
    function category($cid)
    {
        return D('article_category')->fetch($cid);
    }

}