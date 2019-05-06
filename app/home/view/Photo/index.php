<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><span class="gt"> &gt;&gt; </span><?php echo $category['cat_name'];?></div>
    </div>
    <div class="box-body height-auto">
        <?php if($rows){ ?>
        <div class="image-list">
            <?php foreach($rows as $row){ ?>
            <div class="image-item">
                <a rel="group" href="<?php echo $row['img1']; ?>" title="<?php echo $row['title'] ?>">
                    <img src="<?php echo $row['img2']; ?>" alt="<?php echo $row['title'];?>">
                    <span class="image-name"><?php echo $row['title'];?></span>
                </a>
            </div>
            <?php }?>
        </div>
        <div class="paging"><?php echo $paging; ?></div>
        <?php }else{ ?>
        <div class="empty">暂无内容</div>
        <?php } ?>
    </div>
</div>
<link rel="stylesheet" href="<?php css('common/fancybox/jquery.fancybox'); ?>">
<script src="<?php js('common/fancybox/jquery.fancybox'); ?>"></script>
<script>
    $(function ($) {
        $('a[rel=group]').fancybox();
    });
</script>