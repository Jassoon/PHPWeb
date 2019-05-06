<div class="tab-bar">
    <ul class="tab">
        <?php if($this->auth(CONTROLLER, 'add')){ ?>
        <li class="tab-item"><a href="<?php echo url('ProductCategory-add'); ?>">添加类别</a></li>
        <?php } ?>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">类别列表</a></li>
    </ul>
</div>
<div class="content">
    <div class="breadcrumbs">
        当前位置： <a href="<?php echo url('ProductCategory'); ?>">顶级类别</a>
        <?php foreach($path as $val){ ?>
        <span class="divider">/</span> <a href="<?php echo url('ProductCategory'); ?>?pid=<?php echo $val['id']; ?>"><?php echo $val['cat_name']; ?></a>
        <?php } ?>
    </div>
    <?php if($nodes){ ?>
        <form method="post" id="listForm">
        <table class="list">
            <tr>
                <th width="30"><input id="checkAll" type="checkbox"></th>
                <th width="60">排序</th>
                <th width="300">名称</th>
                <th width="60">子类</th>
                <th width="60" colspan="2">操作</th>
                <th></th>
            </tr>
            <?php
            foreach($nodes as $row){
                $isParent = $tree->isParent($row['id']);
            ?>
            <tr align="center">
                <td><input type="checkbox" name="id[<?php echo $row['id'];?>]" value="<?php echo $row['id'];?>"></td>
                <td><input type="text" data-type="float" name="orderly[<?php echo $row['id'];?>]" value="<?php echo $row['orderly'] ?>"></td>
                <td align="left"><a title="编辑" href="<?php echo url('ProductCategory-edit', $row['id']); ?>"><?php echo $row['cat_name'];?></a></td>
                <td><?php if($isParent){ ?><a href="<?php echo url('ProductCategory'); ?>?pid=<?php echo $row['id']; ?>">查看</a><?php } ?></td>
                <td width="30"><a href="<?php echo url('ProductCategory-edit', $row['id']); ?>">编辑</a></td>
                <td width="30"><?php if(!$isParent && $this->auth(CONTROLLER, 'del')){ ?><a class="del" href="<?php echo url('ProductCategory-del', $row['id']); ?>">删除</a><?php } ?></td>
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
</div>