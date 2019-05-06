<?php
/**
 * Class View
 * @package core\lib
 */

namespace core\lib;

class View
{
    private
        $vars = [], //模板变量
        $content, //模板内容
        $layout = ''; //模板布局文件

    function __set($key, $val)
    {
        $this->vars[$key] = $val;
    }

    function __get($key)
    {
        return isset($this->vars[$key]) ? $this->vars[$key] : null;
    }

    function __isset($key)
    {
        return isset($this->vars[$key]);
    }

    /**
     * 设置布局文件
     * @param string $layout
     * @return $this
     */
    function layout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * 获取视图文件的真实路径
     * @param string $filename 视图文件名
     * @return string 视图文件的真实路径
     */
    function realView($filename = '')
    {
        if ($filename == '') {
            $filename = CONTROLLER . DIRECTORY_SEPARATOR . ACTION;
        }
        return VIEW_DIR . $filename . '.php';
    }

    /**
     * 变量赋值
     * @param string|array $key
     * @param null|string $value
     * @return $this
     */
    function assign($key, $value = null)
    {
        if (is_array($key)) {
            $this->vars = array_merge($this->vars, $key);
        } else {
            $this->vars[$key] = $value;
        }
        return $this;
    }

    /**
     * 渲染模板并输出
     * @param string $filename
     * @param bool $show
     * @return string
     */
    function display($filename = '', $show = true)
    {
        $view = $this->realView($filename);

        //模板变量赋值
        if ($this->vars) {
            extract($this->vars, EXTR_PREFIX_SAME, 'data');
        }

        ob_start(); //开启缓冲区
        if (is_file($view)) {
            include($view);
        } else {
            halt('The View File:' . $view . ' is not exists!');
        }
        $this->content = ob_get_clean();

        //加载布局文件
        if ($this->layout) {
            ob_start();
            $layout = $this->realView($this->layout);
            if (is_file($layout)) {
                include($layout);
            } else {
                halt('The Layout File:' . $layout . ' is not exists!');
            }
            $this->content = ob_get_clean();
        }

        if ($show) {
            echo $this->content; //输出内容
        } else {
            return $this->content;
        }
        return true;
    }

    function widget($filename, array $vars = [])
    {
        $file = VIEW_DIR . DIRECTORY_SEPARATOR . $filename . '.php';
        if (is_file($file)) {
            if ($vars) {
                extract($vars, EXTR_PREFIX_SAME, 'data');
            }
            include($file);
        }
    }

}