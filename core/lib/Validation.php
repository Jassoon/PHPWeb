<?php
/**
 * Class Validation
 * @package core\lib
 */

namespace core\lib;

class Validation
{
    protected $data = []; //验证数据
    protected $rules = []; //验证规则
    protected $error = ''; //错误信息

    function __construct(array $data = [], array $rules = [])
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    function getError()
    {
        return $this->error;
    }

    //数据验证
    function check()
    {
        foreach ($this->rules as $val) {
            $data = $this->getValue($val[0]);
            $func = method_exists($this, $val[1]) ? $val[1] : '_regexp'; //验证方法
            $condition = ($func == 'required') ? true : (trim($data)); //验证条件
            if ($condition && (false === call_user_func_array([$this, $func], $val))) {
                $this->error = $val[2];
                return false;
            }
        }
        return true;
    }

    //必填
    protected function required($field)
    {
        return '' != trim($this->getValue($field));
    }

    //日期
    protected function date($field)
    {
        $data = $this->getValue($field);
        $pattern = '/^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/';
        return preg_match($pattern, $data) && strtotime($data);
    }

    //等于某个值
    protected function equal($field, $func, $message, $to)
    {
        return $this->getValue($field) === $to;
    }

    //等于某个字段的值
    protected function equalTo($field, $func, $message, $to)
    {
        return $this->getValue($field) === $this->getValue($to);
    }

    //正则验证
    protected function _regexp($field, $regexp)
    {
        $data = $this->getValue($field);
        $patterns = [
            'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url' => '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency' => '/^\d+(\.\d+)?$/', //货币
            'zip' => '/^\d{6}$/', //邮编
            'number' => '/^\d+$/', //数字
            'int' => '/^[-\+]?\d+$/', //整数
            'float' => '/^[-\+]?\d+(\.\d+)?$/', //浮点数
            'english' => '/^[A-Za-z]+$/', //英文
            'qq' => '/^[1-9][\d]{4,10}$/', //QQ
            'mobile' => '/^[1-9][\d]{10}$/', //手机
            'tel' => '/^([\d]{3}\-[\d]{8})|([\d]{4}\-[\d]{7})$/' //电话
        ];
        if (isset($patterns[$regexp])) {
            return preg_match($patterns[$regexp], $data) === 1;
        }
        if (preg_match('/^\/\S+\/$/', $regexp) === 1) {
            return preg_match($regexp, $data) === 1;
        }
        return true;
    }

    //获取数据的值
    function getValue($key)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : '';
    }

}