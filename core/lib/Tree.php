<?php
/**
 * Class Tree
 * @package core\lib
 */

namespace core\lib;

class Tree
{
    public $data = []; //分类数据

    /**
     * 构造函数
     * @param array $data 分类数据
     */
    function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * 查找指定节点
     * @param int $id 节点id
     * @return array
     */
    function find($id)
    {
        static $map = [];
        if (empty($map) && $this->data) {
            foreach ($this->data as $val) {
                $map[$val['id']] = $val;
            }
        }
        return array_key_exists($id, $map) ? $map[$id] : [];
    }

    /**
     * 查找子节点
     * @param int $pid 父节点id
     * @return array
     */
    function children($pid = 0)
    {
        $nodes = [];
        foreach ($this->data as $val) {
            if ($val['pid'] == $pid) {
                $nodes[] = $val;
            }
        }
        return $nodes;
    }

    /**
     * 判断当前节点是否为父节点
     * @param int $id 节点id
     * @return boolean
     */
    function isParent($id)
    {
        $result = false;
        foreach ($this->data as $val) {
            if ($val['pid'] == $id) {
                $result = true;
                break;
            }
        }
        return $result;
    }

    /**
     *获取当前节点至根节点的路径
     * @param int $id 节点id
     * @return array
     */
    function getPath($id)
    {
        $list = [];
        if (!$id) {
            return $list;
        }

        $node = $this->find($id);
        if ($node && $node['pid'] && $node['path']) {
            $parent = explode('-', $node['path']);
            foreach ($parent as $v) {
                $list[] = $this->find($v);
            }
        }
        $list[] = $node;
        return $list;
    }

    /**
     * 获取当前分类下所有子类的id,包含当前分类id
     * @param $id
     * @return string
     */
    function getFamilyId($id)
    {
        $arr[] = $id;
        $nodes = $this->children($id);
        if ($nodes) {
            foreach ($nodes as $val) {
                $arr[] = $val['id'];
            }
        }
        return implode(',', $arr);
    }

    /**
     * 递归生成下拉列表
     * @param int $pid 父节点id
     * @param string $default 默认显示id
     * @param string $indent
     */
    function option($pid = 0, $default = '', $indent = '')
    {
        $nodes = $this->children($pid);
        if ($nodes) {
            foreach ($nodes as $val) {
                if ($val['id'] == $default) {
                    $format = '<option value="%s" selected="selected">%s</option>';
                } else {
                    $format = '<option value="%s">%s</option>';
                }
                printf($format, $val['id'], $indent . $val['cat_name']);
                $this->option($val['id'], $default, $indent . str_repeat('&nbsp;', 4));
            }
        }
    }

    /**
     * 生成下拉列表组 只能生成二级列表
     * @param int $pid
     * @param string $selected
     * @return string
     */
    function option_group($pid = 0, $selected = '')
    {
        $html = '';
        foreach ($this->children($pid) as $val) {
            $html .= sprintf('<optgroup label="%s">', $val['cat_name']);
            foreach ($this->children($val['id']) as $v) {
                if ($v['id'] == $selected) {
                    $html .= sprintf('<option value="%s" selected="selected">%s</option>', $v['id'], $v['cat_name']);
                } else {
                    $html .= sprintf('<option value="%s">%s</option>', $v['id'], $v['cat_name']);
                }
            }
            $html .= '</optgroup>';
        }
        return $html;
    }

    /**
     * 递归生成ul列表
     * @param int $pid
     * @param string $link
     * @param int $current
     * @param int $level
     */
    function listing($pid = 0, $link = 'product-index', $current = 0, $level = 0)
    {
        $nodes = $this->children($pid);
        if ($nodes) {
            printf('<ul class="tree-ul tree-level-%d">', $level);
            foreach ($nodes as $val) {
                $currentClass = ($val['id'] == $current) ? ' current' : '';
                printf('<li class="tree-li tree-level-%d%s">', $level, $currentClass);
                printf('<a class="tree-a tree-level-%d%s" href="%s" title="%s">%s</a>', $level, $currentClass, url($link, $val['id']), $val['cat_name'], $val['cat_name']);
                $this->listing($val['id'], $link, $current, $level + 1);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

    function export($pid = 0)
    {
        $tree = [];
        $nodes = $this->children($pid);
        foreach ($nodes as $val) {
            $list = [];
            $list['value'] = $val['id'];
            $list['label'] = $val['cat_name'];
            $children = $this->export($val['id']);
            if ($children) {
                $list['children'] = $children;
            }
            $tree[] = $list;
        }
        return $tree;
    }
}