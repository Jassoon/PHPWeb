<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><span class="gt"> &gt;&gt; </span><?php echo $category['cat_name'];?></div>
    </div>
    <div class="box-body height-auto">
        <div class="article-head">
            <h2 class="article-title"><?php echo $data['title']; ?></h2>
            <div class="article-info">
                <span class="article-author">来自：<a href="<?php echo $author_url; ?>" target="_blank"><?php echo $author; ?></a></span>
                <span class="article-date">发布时间：<?php echo $data['create_date'];?></span>
            </div>
        </div>
        <div class="content editor"><?php echo $this->filter($data['content']); ?></div>
        <?php if($prev || $next){ ?>
        <div class="boxoff"><b></b></div>
        <ul class="context">
            <?php if($prev){ ?>
            <li class="context-prev"><a href="<?php echo url('article-item', $prev['id']); ?>">上一篇：<?php echo $prev['title']; ?></a></li>
            <?php } ?>
            <?php if($next){ ?>
            <li class="context-next"><a href="<?php echo url('article-item', $next['id']); ?>">下一篇：<?php echo $next['title']; ?></a></li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
</div>