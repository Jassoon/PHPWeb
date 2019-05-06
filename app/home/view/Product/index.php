<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><?php echo $path; ?></div>
    </div>
    <div class="box-body height-auto">
        <?php if($rows){ ?>
        <div class="image-list">
            <?php foreach($rows as $row){ ?>
            <div class="image-item">
                <a href="<?php echo url('product-item', $row['id']); ?>" title="<?php echo $row['name'];?>">
                    <img src="<?php echo $row['img2']; ?>" alt="<?php echo $row['name'];?>">
                    <span class="image-name"><?php echo $row['name'];?></span>
                </a>
            </div>
            <?php } ?>
        </div>
        <div class="paging"><?php echo $paging; ?></div>
        <?php }else{ ?>
        <div class="empty">暂无内容</div>
        <?php } ?>
    </div>
</div>