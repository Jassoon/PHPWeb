<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?php echo url('File-add'); ?>">添加文件</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">文件列表</a></li>
    </ul>
</div>
<div class="content">
    <form>
        <div class="panel">
            <label>类别：<select name="cat" id="category" class="mr10">
                <option value="">全部类别</option>
                <?php option($category, 'id', 'cat_name', get('cat')) ?>
            </select></label>
            <label>名称：<input name="title" type="search" value="<?php echo get('title'); ?>" size="30" results="s" x-webkit-grammar="builtin:translate" x-webkit-speech></label>
            <button type="submit" class="btn">开始搜索</button>
            <button type="button" class="btn" onClick="location.replace(location.pathname)">显示全部</button>
        </div>
    </form>
    <?php if($rows){ ?>
        <form method="post" id="listForm">
        <table class="list">
            <tr>
                <th width="30"><input id="checkAll" type="checkbox"></th>
                <th width="60">排序</th>
                <th>文件名称</th>
                <th>文件大小</th>
                <th>文件类别</th>
                <th width="100">文件下载</th>
                <th width="60">前台显示</th>
                <th width="60">首页显示</th>
                <th width="60" colspan="2">操作</th>
            </tr>
            <?php
            foreach($rows as $row){
                $filename = $row['title'] . '.' . pathinfo($row['file'], PATHINFO_EXTENSION);
            ?>
            <tr align="center">
                <td><input name="id[<?php echo $row['id'];?>]" type="checkbox" value="<?php echo $row['id'];?>"></td>
                <td><input type="text" data-type="float" name="orderly[<?php echo $row['id'];?>]" value="<?php echo $row['orderly'] ?>"></td>
                <td align="left"><a href="<?php echo url('File-edit', $row['id']); ?>" title="编辑"><?php echo $row['title']; ?></a></td>
                <td align="left"><?php echo file_size($row['size']); ?></td>
                <td align="left"><?php echo $row['cat_name']; ?></td>
                <td><a class="file-icon" href="<?php echo $row['file']; ?>" download="<?php echo $filename; ?>" title="下载">下载</a></td>
                <td><span class="right" data-href="<?php echo url('File-ajax-show', $row['id']); ?>" data-val="<?php echo $row['is_show'] ?>"></span></td>
                <td><span class="right" data-href="<?php echo url('File-ajax-tj', $row['id']); ?>" data-val="<?php echo $row['is_tj']; ?>"></span></td>
                <td width="30"><a href="<?php echo url('File-edit', $row['id']); ?>">编辑</a></td>
                <td width="30"><a class="del" href="<?php echo url('File-del', $row['id']); ?>">删除</a></td>
            </tr>
            <?php } ?>
        </table>
    </form>
    <ul class="tool-bar">
        <li><button type="button" id="sort" class="btn">排序</button></li>
        <li><button type="button" id="del" class="btn">删除</button></li>
        <li><select id="move" name="move"><option value="">移动到...</option></select></li>
    </ul>
    <?php }else{ ?>
    <div class="empty">暂无内容</div>
    <?php } ?>
    <div class="paging"><?php echo $paging; ?></div>
</div>