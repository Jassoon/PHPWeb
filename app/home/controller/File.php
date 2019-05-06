<?php

namespace app\home\controller;

use \core\lib\Pagination;

class File extends Base
{
    const TABLE = 'file';

    function indexAction($id = '')
    {
        $db = D();
        $id = is_numeric($id) ? $id : '';
        $category = $db->table('file_category')->fetch($id);
        if (!$category) {
            $this->_404();
        }

        $setting = setting();

        //内容查询
        $where = "WHERE `is_show`='1' AND `cat`={$category['id']}";
        $total = $db->table(self::TABLE)->getCount($where);
        $pagination = new Pagination($total, $setting['file_count']);
        $rows = $db->select("$where ORDER BY `orderly` {$setting['file_order']} {$pagination->limit}", 'id, title, file');

        $this->assign([
            'title' => $category['title_bar'] ?: ($category['cat_name'] . '_' . $setting['site_name']),
            'description' => $category['description'],
            'keywords' => $category['keywords'],
            'category' => $category,
            'paging' => $pagination->output(),
            'rows' => $rows,
        ]);

        $this->display();
    }

    function itemAction($id = 0)
    {
        if (!($id && is_numeric($id))) {
            $this->_404();
        }

        $data = D(self::TABLE)->fetch($id);
        $file = realpath($data['file']);
        $filename = $data['title'] . '.' . pathinfo($data['file'], PATHINFO_EXTENSION);

        //解决IE中文乱码的问题
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
            $filename = urlencode($filename);
        }

        header('Content-type:application/octet-stream');
        header('Content-Disposition:attachment; filename=' . $filename);
        header('Content-Length:' . filesize($file));
        readfile($file);
    }

}