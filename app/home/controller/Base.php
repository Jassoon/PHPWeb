<?php

namespace app\home\controller;

use \core\lib\Controller;
use \core\lib\Tree;

class Base extends Controller
{

    protected function _init()
    {
        $this->layout('Layout');
        $this->assign([
            'title' => setting('title_bar'),
            'description' => '', //页面描述
            'keywords' => '', //页面关健词
            'navIndex' => CONTROLLER, //导航索引
            'bodyClass' => ['c-' . strtolower(CONTROLLER), 'a-' . strtolower(ACTION)]
        ]);
    }

    function _404()
    {
        header('HTTP/1.1 302 Not Found');
        header('status: 302 Not Found');
        $this->display('404');
        exit;
    }

    function _empty()
    {
        $this->_404();
    }

    //Filter
    function filter($str)
    {
        $pattern = '/"(upload\/editor\/image\/\d{6}\/\d+\.(jpg|png|gif))"/';
        return preg_replace($pattern, BASE_URL . '$1', $str); //图像地址替换为绝对地址
    }

    //产品分类
    function getProductCategoryTree()
    {
        static $tree = null;
        if (is_null($tree)) {
            $category = D('product_category')->select("ORDER BY `orderly` ASC");
            $tree = new Tree($category);
        }
        return $tree;
    }

    function getImageList($cat = 1)
    {
        return D('image')->select("WHERE `is_show`='1' AND `cat`={$cat} ORDER BY `orderly` ASC", 'url, img, title');
    }

    function getImageItem($cat = 0)
    {
        return D('image')->fetch("WHERE `is_show`='1' AND `cat`={$cat} ORDER BY `orderly` ASC", 'url, img, title');
    }

    //友情链接
    function getLinkList()
    {
        return D('link')->select("WHERE `is_show`='1' AND `is_tj`='1' ORDER BY `orderly` ASC");
    }

    //在线客服
    function getKefuList()
    {
        return D('kefu')->select("WHERE `is_show`='1' ORDER BY `orderly` ASC");
    }

}