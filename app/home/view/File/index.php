<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><span class="gt"> &gt;&gt; </span><?php echo $category['cat_name']; ?></div>
    </div>
    <div class="box-body height-auto">
        <?php if($rows){ ?>
        <div class="content">
            <ul class="list">
                <?php
                foreach($rows as $row){
                    $filename = $row['title'] . '.' . pathinfo($row['file'], PATHINFO_EXTENSION);
                ?>
                <li><a class="fr" href="<?php echo $row['file']; ?>" download="<?php echo $filename; ?>" title="点击下载">点击下载</a><?php echo $row['title'];?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="paging"><?php echo $paging; ?></div>
        <?php }else{ ?>
        <div class='empty'>暂无内容</div>
        <?php } ?>
    </div>
</div>