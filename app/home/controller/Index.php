<?php

namespace app\home\controller;

class Index extends Base
{

    function indexAction()
    {
        $setting = setting();
        $this->assign([
            'description' => $setting['description'],
            'keywords' => $setting['keywords']
        ]);
        $this->display();
    }

    function getArticleList($cat = 1)
    {
        $order = setting('article_order');
        return D('article')->select("WHERE `is_show`='1' AND `is_tj`='1' AND `cat`={$cat} ORDER BY `orderly` {$order} LIMIT 0, 6", 'id, title');
    }

    function getProductList()
    {
        $order = setting('product_order');
        return D('product')->select("WHERE `is_show`='1' AND `is_tj`='1' ORDER BY `orderly` {$order} LIMIT 0, 12", 'id, name, img2');
    }

}