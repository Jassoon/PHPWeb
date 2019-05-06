<div class="box">
    <div class="box-head">
        <div class="box-title">关于我们</div>
        <a class="box-more" href="<?php echo url('page-index-1'); ?>" title="更多">更多...</a>
    </div>
    <div class="box-body clearfix editor"><?php echo setting('about'); ?></div>
</div>
<div class="box">
    <div class="box-head">
        <div class="box-title">产品展示</div>
        <a class="box-more" href="<?php echo url('product'); ?>" title="更多">更多...</a></div>
    <div class="box-body">
        <div class="image-list">
            <?php
            $rows = $this->getProductList();
            foreach($rows as $row){
            ?>
            <div class="image-item">
                <a href="<?php echo url('product-item', $row['id']); ?>" title="<?php echo $row['name']; ?>">
                    <img src="<?php echo $row['img2']; ?>" alt="<?php echo $row['name']; ?>">
                    <span class="image-name"><?php echo $row['name']; ?></span>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>