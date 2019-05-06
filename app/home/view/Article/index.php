<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><span class="gt"> &gt;&gt; </span><?php echo $category['cat_name'];?></div>
    </div>
    <div class="box-body height-auto">
        <?php if($rows){ ?>
        <ul class="list mb10">
            <?php foreach($rows as $row){ ?>
            <li><span class="list-date"><?php echo $row['create_date'];?></span><a href="<?php echo url('article-item', $row['id']); ?>" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></li>
            <?php }?>
        </ul>
        <div class="paging"><?php echo $paging; ?></div>
        <?php }else{ ?>
        <div class="empty">暂无内容</div>
        <?php } ?>
    </div>
</div>