<?php

namespace extend\captcha;
/**
 * Class Captcha
 * @package extend\captcha
 */
class Captcha
{
    public
        $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789', //随机因子
        $codeLength = 4, //验证码长度
        $width = 130, //宽度
        $height = 50, //高度
        $fontSize = 20, //字体大小
        $fontColor; //字体颜色

    private
        $font, //字体
        $code, //验证码
        $img; //图形资源句柄

    //构造方法初始化
    public function __construct()
    {
        $this->font = __DIR__ . '/elephant.ttf';
    }

    //生成随机码
    private function createCode()
    {
        $code = '';
        $len = strlen($this->charset) - 1;
        for ($i = 0; $i < $this->codeLength; $i++) {
            $code .= $this->charset[mt_rand(0, $len)];
        }
        $this->code = $code;
    }

    //生成背景
    private function createBg()
    {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
    }

    //生成线条、雪花
    private function createLine()
    {
        for ($i = 0; $i < 6; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
        }
        for ($i = 0; $i < 100; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '*', $color);
        }
    }

    //生成文字
    private function createFont()
    {
        $_x = $this->width / $this->codeLength;
        for ($i = 0; $i < $this->codeLength; $i++) {
            $this->fontColor = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->img, $this->fontSize, mt_rand(-30, 30), $_x * $i + mt_rand(1, 5), $this->height / 1.4, $this->fontColor, $this->font, $this->code[$i]);
        }
    }

    //输出
    private function output()
    {
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }

    /**
     * 生成验证码图像
     */
    public function create()
    {
        $this->createBg();
        $this->createCode();
        $this->createLine();
        $this->createFont();
        $this->output();
    }

    /**
     * 获取验证码
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

}