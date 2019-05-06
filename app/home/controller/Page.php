<?php

namespace app\home\controller;

class Page extends Base
{
    const TABLE = 'page';

    function indexAction($id = '')
    {
        if (!($id && is_numeric($id))) {
            $this->_404();
        }

        $data = D(self::TABLE)->fetch($id);
        if (!$data) {
            $this->_404();
        }

        $this->assign([
            'title' => $data['title_bar'] ?: ($data['title'] . '_' . setting('site_name')),
            'description' => $data['description'],
            'keywords' => $data['keywords'],
            'navIndex' => 'Page-' . $data['id'],
            'data' => $data
        ]);

        $this->display();
    }

}