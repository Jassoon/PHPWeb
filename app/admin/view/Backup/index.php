<style scoped>
    .list { counter-reset: index; }
    .list tr td:first-child { counter-increment: index; }
    .list tr td:first-child:after { content: counter(index); }
</style>
<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item <?php if($type == 'sql'){ echo 'current'; } ?>"><a href="<?php echo url('Backup-index-sql'); ?>">数据库备份</a></li>
        <li class="tab-item <?php if($type == 'file'){ echo 'current'; } ?>"><a href="<?php echo url('Backup-index-file'); ?>">附件备份</a></li>
    </ul>
</div>
<div class="content">
    <div class="panel">
        <?php if($type == 'sql'){ ?>
        <button id="backup" class="btn btn-blue" data-href="<?php echo url('Backup-create-sql'); ?>">创建数据库备份</button>
        <?php }else{ ?>
        <button id="backup" class="btn btn-blue" data-href="<?php echo url('Backup-create-file'); ?>">创建附件备份</button>
        <?php } ?>
        <span class="loading"></span>
    </div>
    <?php if($files){ ?>
    <table class="list">
        <tr>
            <th width="30"></th>
            <th width="360">File</th>
            <th width="160">Time</th>
            <th width="100">Size</th>
            <th width="100">Remove</th>
            <th></th>
        </tr>
        <?php foreach($files as $key=>$file){ $filename = basename($file); ?>
        <tr align="center">
            <td></td>
            <td align="left"><a class="file-icon" href="<?php echo url('Backup-down'); ?>?file=<?php echo $filename; ?>" title="下载"><?php echo $filename; ?></a></td>
            <td><?php echo date('Y-m-d H:i:s', filemtime($file)); ?></td>
            <td><?php echo file_size(filesize($file)); ?></td>
            <td><a class="del" href="<?php echo url('Backup-del'); ?>?file=<?php echo $filename; ?>">删除</a></td>
            <td></td>
        </tr>
        <?php } ?>
    </table>
    <?php }else{ ?>
    <div class="empty">暂无内容</div>
    <?php } ?>
</div>
<script src="<?php js('admin/js/backup'); ?>"></script>