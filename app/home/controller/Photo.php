<?php

namespace app\home\controller;

use \core\lib\Pagination;

class Photo extends Base
{
    const TABLE = 'photo';

    function indexAction($id = '')
    {
        $db = D();
        $id = is_numeric($id) ? $id : '';
        $category = $db->table('photo_category')->fetch($id);
        if (!$category) {
            $this->_404();
        }

        //相册列表
        $setting = setting();
        $where = "WHERE `is_show`='1' AND `cat` = {$category['id']}";
        $total = $db->table(self::TABLE)->getCount($where);
        $pagination = new Pagination($total, $setting['photo_count']);
        $rows = $db->select("$where ORDER BY `orderly` {$setting['photo_order']} {$pagination->limit}");

        $this->assign([
            'title' => $category['title_bar'] ?: ($category['cat_name'] . '_' . $setting['site_name']),
            'description' => $category['description'],
            'keywords' => $category['keywords'],
            'category' => $category,
            'rows' => $rows,
            'paging' => $pagination->output()
        ]);

        $this->display();
    }

}