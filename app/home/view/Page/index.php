<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><span class="gt"> &gt;&gt; </span><?php echo $data['title'];?></div>
    </div>
    <div class="box-body height-auto">
        <div class="content editor"><?php echo $this->filter($data['content']); ?></div>
    </div>
</div>