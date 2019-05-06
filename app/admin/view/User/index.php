<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?= url('User-add'); ?>">添加用户</a></li>
        <li class="tab-item current"><a href="<?= SELF_URL; ?>">用户列表</a></li>
    </ul>
</div>
<div class="content">
    <?php if ($rows) { ?>
    <table class="list">
        <tr>
            <th width="30">ID</th>
            <th>姓名</th>
            <th>帐号</th>
            <th width="90">login number</th>
            <th width="160">last login time</th>
            <th width="160">last login IP</th>
            <th width="60" colspan="2">操作</th>
        </tr>
        <?php foreach($rows as $row){ ?>
        <tr align="center">
            <td><?php echo $row['id']; ?></td>
            <td align="left"><a title="编辑" href="<?= url('User-edit', $row['id']); ?>"><?= $row['name']; ?></a></td>
            <td align="left"><?= $row['account']; ?></td>
            <td><?= $row['login_number']; ?></td>
            <td><?= date('Y-m-d H:i:s', $row['last_login_time']); ?></td>
            <td><?= long2ip($row['last_login_ip']); ?></td>
            <td width="30"><a href="<?= url('User-edit', $row['id']); ?>">编辑</a></td>
            <td width="30"><?php if($row['id']!=1 && $this->auth(CONTROLLER, 'del')){ ?><a class="del" href="<?= url('User-del', $row['id']); ?>">删除</a><?php } ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
    <div class="empty">暂无内容</div>
    <?php } ?>
    <div class="paging"><?= $paging; ?></div>
</div>