<div class="box">
    <div class="box-head">
        <div class="box-title">产品类别</div>
    </div>
    <div class="box-body"><?php $this->getProductCategoryTree()->listing(); ?></div>
</div>
<!--/产品分类-->
<div class="box">
    <div class="box-head">
        <div class="box-title">联系我们</div>
    </div>
    <div class="box-body"><?php echo setting('contact'); ?></div>
</div>
<!--/联系我们-->
<div class="box">
    <div class="box-head">
        <div class="box-title">友情链接</div>
    </div>
    <div class="box-body">
        <ul class="list">
            <?php
            $links = $this->getLinkList();
            foreach($links as $val){
            ?>
            <li><a href="<?php echo $val['url'];?>" title="<?php echo $val['title'] ? $val['title'] : $val['name']; ?>" target="_blank"><?php echo $val['name'];?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<!--/友情链接-->