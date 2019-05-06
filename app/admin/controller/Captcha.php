<?php

namespace app\admin\controller;

use \core\lib\Controller;

class Captcha extends Controller
{

    function indexAction()
    {
        $captcha = new \extend\captcha\Captcha;
        $captcha->width = 116;
        $captcha->height = 36;
        $captcha->fontSize = 18;
        $captcha->create();
        $_SESSION['captcha'] = strtoupper($captcha->getCode());
    }

}