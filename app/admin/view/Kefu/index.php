<?php $kefuType = C('KEFU_TYPE'); ?>
<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?php echo url('Kefu-add'); ?>">添加客服</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">客服列表</a></li>
    </ul>
</div>
<div class="content">
    <?php if($rows){ ?>
        <form method="post" id="listForm">
        <table class="list">
            <tr>
                <th width="30"><input id="checkAll" type="checkbox"></th>
                <th width="60">排序</th>
                <th>客服类型</th>
                <th width="*">客服帐号</th>
                <th width="*">客服名称</th>
                <th width="60">前台显示</th>
                <th width="60" colspan="2">操作</th>
            </tr>
            <?php foreach($rows as $row){ ?>
            <tr align="center">
                <td><input type="checkbox" name="id[<?php echo $row['id'];?>]" value="<?php echo $row['id'];?>"></td>
                <td><input type="text" data-type="float" name="orderly[<?php echo $row['id'];?>]" value="<?php echo $row['orderly'] ?>"></td>
                <td align="left"><?php echo isset($kefuType[$row['type']]) ? $kefuType[$row['type']] : ''; ?></td>
                <td align="left"><?php echo $row['account'];?></td>
                <td align="left"><?php echo $row['name'];?></td>
                <td><span class="right" data-href="<?php echo url('Kefu-ajax-show', $row['id']); ?>" data-val="<?php echo $row['is_show']; ?>"></span></td>
                <td width="30"><a href="<?php echo url('Kefu-edit', $row['id']); ?>">编辑</a></td>
                <td width="30"><a class="del" href="<?php echo url('Kefu-del', $row['id']); ?>">删除</a></td>
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