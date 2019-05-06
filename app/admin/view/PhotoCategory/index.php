<div class="tab-bar">
    <ul class="tab">
        <?php if($this->auth(CONTROLLER, 'add')){ ?>
        <li class="tab-item"><a href="<?php echo url('PhotoCategory-add'); ?>">添加类别</a></li>
        <?php } ?>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">类别列表</a></li>
    </ul>
</div>
<div class="content">
    <?php if($rows){ ?>
        <form method="post" id="listForm">
        <table class="list">
            <tr>
                <th width="30"><input id="checkAll" type="checkbox"></th>
                <th width="60">排序</th>
                <th width="300">名称</th>
                <th width="60">统计</th>
                <th width="60">ID</th>
                <th width="60" colspan="2">操作</th>
                <th></th>
            </tr>
            <?php
            $db = D('photo');
            foreach($rows as $row){
                $sum = $db->getCount("WHERE `cat`={$row['id']}");
            ?>
            <tr align="center">
                <td><input type="checkbox" name="id[<?php echo $row['id']; ?>]" value="<?php echo $row['id']; ?>"></td>
                <td><input type="text" data-type="float" name="orderly[<?php echo $row['id']; ?>]" value="<?php echo $row['orderly']; ?>"></td>
                <td align="left"><a title="编辑" href="<?php echo url('PhotoCategory-edit', $row['id']); ?>"><?php echo $row['cat_name']; ?></a></td>
                <td><?php echo $sum; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td width="30"><a href="<?php echo url('PhotoCategory-edit', $row['id']); ?>">编辑</a></td>
                <td width="30"><?php if(!$sum && $this->auth(CONTROLLER, 'del')){ ?><a class="del" href="<?php echo url('PhotoCategory-del', $row['id']); ?>">删除</a><?php } ?></td>
                <td></td>
            </tr>
            <?php } ?>
        </table>
    </form>
    <ul class="tool-bar">
        <li><button type="button" id="sort" class="btn">排序</button></li>
    </ul>
    <?php }else{ ?>
    <div class="empty">暂无内容</div>
    <?php } ?>
    <div class="paging"><?php echo $paging; ?></div>
</div>