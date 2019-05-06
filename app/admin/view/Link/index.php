<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?php echo url('Link-add'); ?>">添加链接</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">链接列表</a></li>
    </ul>
</div>
<div class="content">
    <?php if($rows){ ?>
        <form method="post" id="listForm">
        <table class="list">
            <tr>
                <th width="30"><input id="checkAll" type="checkbox"></th>
                <th width="60">排序</th>
                <th>名称</th>
                <th width="*">链接</th>
                <th width="*">描述</th>
                <th width="60">前台显示</th>
                <th width="60">首页显示</th>
                <th width="60" colspan="2">操作</th>
            </tr>
            <?php foreach($rows as $row){ ?>
            <tr align="center">
                <td><input type="checkbox" name="id[<?php echo $row['id'];?>]" value="<?php echo $row['id'];?>"></td>
                <td><input type="text" data-type="float" name="orderly[<?php echo $row['id'];?>]" value="<?php echo $row['orderly'] ?>"></td>
                <td align="left"><a title="编辑" href="<?php echo url('Link-edit', $row['id']); ?>"><?php echo $row['name'];?></a></td>
                <td align="left"><a href="<?php echo $row['url'];?>" title="打开链接" target="_blank"><?php echo $row['url'];?></a></td>
                <td align="left"><?php echo $row['title'];?></td>
                <td><span class="right" data-href="<?php echo url('Link-ajax-show', $row['id']); ?>" data-val="<?php echo $row['is_show'] ?>"></span></td>
                <td><span class="right" data-href="<?php echo url('Link-ajax-tj', $row['id']); ?>" data-val="<?php echo $row['is_tj']; ?>"></span></td>
                <td width="30"><a href="<?php echo url('Link-edit', $row['id']); ?>">编辑</a></td>
                <td width="30"><a class="del" href="<?php echo url('Link-del', $row['id']); ?>">删除</a></td>
            </tr>
            <?php } ?>
        </table>
    </form>
    <ul class="tool-bar">
        <li><button type="button" id="sort" class="btn">排序</button></li>
        <li><button type="button" id="del" class="btn">删除</button></li>
    </ul>
    <?php }else{ ?>
    <div class="empty">暂无内容</div>
    <?php } ?>
    <div class="paging"><?php echo $paging; ?></div>
</div>