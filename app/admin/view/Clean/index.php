<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">无效文件</a></li>
    </ul>
</div>
<div class="content">
    <div class="panel clearfix">
        <ul class="menu clearfix">
            <?php foreach($list as $val){ ?>
            <li class="menu-item<?php if($navIndex == $val){ echo ' current'; } ?>"><a class="menu-link" href="<?php echo url('Clean-index', $val); ?>"><?php echo ucfirst($val); ?></a></li>
            <?php } ?>
        </ul>
        <div class="panel-right">
            <button type="button" id="all" class="btn">全选</button>
            <button type="button" id="remove" class="btn btn-blue">删除</button>
            <span class="loading"></span>
        </div>
    </div>
    <?php if($rows){ ?>
    <div id="fileList" class="file-list">
        <?php foreach($rows as $row){ ?>
        <div class="file-item" title="<?php echo $row['file']; ?>&#10;Time: <?php echo $row['time']; ?>&#10;Size: <?php echo $row['size']; ?>" data-file="<?php echo $row['file']; ?>"><img class="lazy" data-original="<?php echo $row['icon']; ?>" src="<?php echo src('admin/image/null.gif'); ?>"></div>
        <?php } ?>
    </div>
    <?php }else{ ?>
    <div class="empty">没有发现无效文件</div>
    <?php } ?>
</div>
<script src="<?php js('admin/js/clean'); ?>"></script>