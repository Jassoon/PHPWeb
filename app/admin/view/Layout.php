<?php $navigate = import(MODULE_DIR . 'navigate.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=1024">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="robots" content="noindex,nofollow">
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="<?php css('common/normalize'); ?>">
<link rel="stylesheet" href="<?php css('admin/style/main'); ?>">
<script>var BASE_URL = "<?php echo BASE_URL; ?>", CONTROLLER = "<?php echo CONTROLLER; ?>", ACTION = "<?php echo ACTION; ?>"; </script>
<script src="<?php js('common/jquery'); ?>"></script>
<script src="<?php js('common/jquery.cookie'); ?>"></script>
<script src="<?php js('admin/js/common') ?>"></script>
</head>

<body>
<div id="header" class="header">
    <a class="logo" href="<?php echo BASE_URL; ?>" title="网站内容管理系统">网站内容管理系统</a>
    <a class="header-link" href="<?php echo setting('site_url'); ?>" target="_blank">网站首页</a>
    <a class="header-link" href="<?php echo url('Index-logout'); ?>">退出登录</a>
</div>
<div id="center" class="center">
    <div id="side" class="side">
        <?php foreach($navigate as $val){ ?>
        <ul class="nav">
            <?php foreach($val as $v){ ?>
                <?php if(empty($v['auth']) || $this->auth($v['auth'])){ ?>
                <li class="nav-item"><a class="nav-link <?php if(CONTROLLER === $v['link']){ echo 'current'; } ?>" href="<?php echo url($v['link']); ?>"><?php echo $v['title']; ?></a></li>
                <?php } ?>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
    <div id="main" class="main"><?php echo $this->content; ?></div>
</div>
<div id="message" class="message"><span id="messageText">:-)</span></div>
</body>
</html>