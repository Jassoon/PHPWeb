<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=1024">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="robots" content="noindex,nofollow">
<title>管理员登录</title>
<link rel="stylesheet" href="<?php css('admin/style/login'); ?>">
</head>

<body>
<!--[if lt IE 9]><div style="color:#fff;text-align:center;border:solid 1px #c62d24;background:#dc3228;padding:6px;margin:6px;">您的浏览器版本太低，部分功能将不被支持，建议您安装新版浏览器！ <a href="https://browsehappy.com/" title="立即升级" target="_blank" style="color:#fff;text-decoration: none;background:#333;display:inline-block;padding:0 6px;">立即升级</a></div><![endif]-->
<div class="login">
    <form id="login" action="<?php echo url('login-query'); ?>">
        <ul class="list">
            <li class="item">
                <input name="account" type="text" autofocus required class="input" id="account" placeholder="帐号" maxlength="16" pattern="^[A-Za-z0-9_\-.]{4,16}$">
            </li>
            <li class="item">
                <input name="password" type="password" required class="input" id="password" placeholder="密码" maxlength="16" pattern="^[A-Za-z0-9_\-.]{4,16}$">
            </li>
            <li class="item captcha">
                <input name="captcha" type="text" required class="input" id="captcha" placeholder="验证码" maxlength="4" pattern="^[A-Za-z0-9]{4}$">
                <img src="<?php echo BASE_URL; ?>captcha?_=<?php echo time(); ?>" alt="验证码" title="换一张" id="captchaImage">
            </li>
            <li class="item item-last">
                <button type="submit" id="submit" class="button" disabled>登录</button>
            </li>
        </ul>
    </form>
</div>
<script>var BACK_URL = "<?php echo get('src', BASE_URL); ?>";</script>
<script src="<?php js('common/jquery'); ?>"></script>
<script src="<?php js('common/crypto-js'); ?>"></script>
<script src="<?php js('admin/js/login'); ?>"></script>
</body>
</html>