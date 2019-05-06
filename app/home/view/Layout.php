<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=1000">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-siteapp">
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo $description; ?>">
<meta name="keywords" content="<?php echo $keywords; ?>">
<link rel="stylesheet" href="<?php css('home/style/main'); ?>">
<script src="<?php js('common/jquery'); ?>"></script>
<script src="<?php js('home/js/common'); ?>"></script>
<?php echo setting('code_header'); ?>
</head>

<body class="<?php echo implode(' ', $bodyClass); ?>">
<div class="wrap">
    <div class="header">
        <div class="fl"><a href="<?php echo BASE_URL; ?>"><img src="<?php echo setting('logo'); ?>" width="600" height="100"></a></div>
        <div class="search">
            <form action="<?php echo url('product-search'); ?>" name="search">
                <input type="search" class="search-input" name="s" value="<?php echo get('s'); ?>" placeholder="产品搜索" required results="s" x-webkit-grammar="builtin:translate" x-webkit-speech>
                <button type="submit" class="search-button">搜索</button>
            </form>
        </div>
    </div>
    <ul class="nav">
        <li class="nav-item"><a class="nav-link <?php if($navIndex === 'Index'){ echo 'current'; } ?>" href="<?php echo BASE_URL; ?>">首页</a></li>
        <li class="nav-line"></li>
        <li class="nav-item"><a class="nav-link <?php if($navIndex === 'Page-1'){ echo 'current'; } ?>" href="<?php echo url('page-index-1'); ?>">公司简介</a></li>
        <li class="nav-line"></li>
        <li class="nav-item"><a class="nav-link <?php if($navIndex === 'Product'){ echo 'current'; } ?>" href="<?php echo url('product'); ?>">产品展示</a></li>
        <li class="nav-line"></li>
        <li class="nav-item"><a class="nav-link <?php if($navIndex === 'Article'){ echo 'current'; } ?>" href="<?php echo url('article'); ?>">新闻动态</a></li>
        <li class="nav-line"></li>
        <li class="nav-item"><a class="nav-link <?php if($navIndex === 'Photo'){ echo 'current'; } ?>" href="<?php echo url('photo'); ?>">成功案例</a></li>
        <li class="nav-line"></li>
        <li class="nav-item"><a class="nav-link <?php if($navIndex === 'Message'){ echo 'current'; } ?>" href="<?php echo url('message'); ?>">客户留言</a></li>
        <li class="nav-line"></li>
        <li class="nav-item"><a class="nav-link <?php if($navIndex === 'Page-2'){ echo 'current'; } ?>" href="<?php echo url('page-index-2'); ?>">联系我们</a></li>
        <li class="nav-line"></li>
        <li class="nav-item"><a class="nav-link <?php if($navIndex === 'File'){ echo 'current'; } ?>" href="<?php echo url('file'); ?>">资料下载</a></li>
    </ul>
    <div id="slide" class="slide">
        <?php $rows = $this->getImageList(1); if($rows){ ?>
            <?php foreach($rows as $row){ ?>
            <div class="slide-item"><a href="<?php echo $row['url']; ?>" title="<?php echo $row['title']; ?>"><img class="slide-img" src="<?php echo $row['img']; ?>"></a></div>
            <?php } ?>
        <?php } ?>
        <div class="slide-arrow slide-prev" style="display:none;"></div>
        <div class="slide-arrow slide-next" style="display:none;"></div>
        <div class="slide-paging"></div>
    </div>
    <!--/Slide-->
    <div class="center clearfix">
        <div id="main" class="main"><?php echo $this->content; ?></div>
        <div id="side" class="side"><?php $this->widget('side'); ?></div>
    </div>
    <div class="footer"><?php echo setting('footer'); ?></div>
</div>
<?php if(setting('kefu')){ $this->widget('kefu'); } ?>
<img id="backTop" class="back-top" src="<?php echo src('home/image/back_top.png'); ?>" alt="返回顶部" width="36" height="36">
<?php echo setting('code_footer'); ?>
</body>
</html>