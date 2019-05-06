<?php
/**
 * Class Pagination
 * @package core\lib
 */

namespace core\lib;

class Pagination
{

    private $rowsTotal; //总计录数
    private $rows; //每页记录数量
    private $pageTotal; //总页数
    private $page; //当前页
    private $url;
    private $itemTotal;
    private $lang = ['row' => '行', 'page' => '页', 'prev' => '上一页', 'next' => '下一页'];
    private $limit;

    /**
     * @param int $rowsTotal 总共有多少条记录
     * @param int $rows 每页显示多少条记录
     */
    function __construct($rowsTotal, $rows = 20)
    {
        $this->rowsTotal = $rowsTotal; //总行数
        $this->rows = $rows; //每页行数
        $pageTotal = $this->pageTotal = ceil($rowsTotal / $rows); //总页数

        //current page
        $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? floor($_GET['page']) : 1;
        $page = $this->page = max(1, min($pageTotal, $page));

        //limit
        $start = ($page - 1) * $rows;
        $this->limit = " LIMIT {$start}, {$rows} ";

        //url parse
        $parse = parse_url($_SERVER['REQUEST_URI']);
        $params = [];
        if (isset($parse['query'])) {
            parse_str($parse['query'], $params);
            if (array_key_exists('page', $params)) {
                unset($params['page']);
            }
        }
        $params['page'] = '';
        $this->url = $parse['path'] . '?' . http_build_query($params);
    }

    function info()
    {
        return [
            'rows_total' => $this->rowsTotal,
            'page_total' => $this->pageTotal,
            'limit' => $this->rows,
            'curr' => $this->page
        ];
    }

    function infoView()
    {
        $start = ($this->page - 1) * $this->rows;
        $end = min($this->page * $this->rows, $this->rowsTotal);
        return "<span>{$start}-{$end}/{$this->rowsTotal} {$this->lang['row']}</span><span>{$this->page}/{$this->pageTotal} {$this->lang['page']}</span>";
    }

    function prevView()
    {
        $prev = $this->page - 1;
        return ($this->page > 1) ? "<a href=\"{$this->url}{$prev}\">{$this->lang['prev']}</a>" : "<span>{$this->lang['prev']}</span>";
    }

    function itemView()
    {
        $half = floor($this->itemTotal / 2);
        $html = '';

        //first
        if ($this->page - $half > 1) {
            $html .= "<a href=\"{$this->url}1\">1</a>";
        }

        //ellipsis
        if ($this->page - $half > 2) {
            $html .= '<span>...</span>';
        }

        //before
        for ($before = $half; $before >= 1; $before--) {
            $page = $this->page - $before;
            if ($page >= 1) {
                $html .= "<a href=\"{$this->url}{$page}\">{$page}</a>";
            }
        }

        //current
        $html .= "<strong>{$this->page}</strong>";

        //after
        for ($after = 1; $after <= $half; $after++) {
            $page = $this->page + $after;
            if ($page <= $this->pageTotal) {
                $html .= "<a href=\"{$this->url}{$page}\">{$page}</a>";
            }
        }

        //ellipsis
        if ($this->pageTotal - ($this->page + $half) >= 2) {
            $html .= '<span>...</span>';
        }

        //last
        if ($this->pageTotal - ($this->page + $half) >= 1) {
            $html .= "<a href=\"{$this->url}{$this->pageTotal}\">{$this->pageTotal}</a>";
        }

        return $html;
    }

    function nextView()
    {
        $next = $this->page + 1;
        return ($this->page < $this->pageTotal) ? "<a href=\"{$this->url}{$next}\">{$this->lang['next']}</a>" : "<span >{$this->lang['next']}</span>";
    }

    /**
     * @param string $module 分页栏模块名称
     * @param int $itemTotal item长度
     * @return string 分页栏HTML
     */
    function output($module = 'prev,item,next', $itemTotal = 9)
    {
        $this->itemTotal = $itemTotal;
        $html = '';
        if ($this->pageTotal) {
            $modules = explode(',', $module);
            foreach ($modules as $val) {
                $fn = $val . 'View';
                if (method_exists($this, $fn)) {
                    $html .= call_user_func([$this, $fn]);
                }
            }
        }
        return $html;
    }

    function __get($var)
    {
        return isset($this->$var) ? $this->$var : null;
    }

}