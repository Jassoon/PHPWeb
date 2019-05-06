<?php $nodes = import(MODULE_DIR . 'auth_nodes.php'); ?>
<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?= url('User-add'); ?>">添加用户</a></li>
        <li class="tab-item"><a href="<?= url('User'); ?>">用户列表</a></li>
        <li class="tab-item current"><a href="<?= SELF_URL; ?>">编辑用户</a></li>
    </ul>
    <ul class="context">
        <li><?php if($prev){ ?><a href="<?= url('User-edit', $prev['id']) ?>" data-target="replace">上一条</a><?php } ?></li>
        <li><?php if($next){ ?><a href="<?= url('User-edit', $next['id']) ?>" data-target="replace">下一条</a><?php } ?></li>
    </ul>
</div>
<div class="content">
    <form action="<?= url('User-update'); ?>" id="userForm" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">姓名：</td>
                <td><input name="name" type="text" autofocus required title="请输入姓名" value="<?= $data['name'] ?>" maxlength="8" size="30"></td>
            </tr>
            <tr>
                <td align="right">帐号：</td>
                <td><input name="account" type="text" required class="ime" title="请输入帐号" autocomplete="off" value="<?= $data['account'] ?>" maxlength="16" size="30"></td>
            </tr>
            <tr>
                <td align="right">密码：</td>
                <td><input name="password" type="password" class="ime" autocomplete="off" maxlength="16" size="30"></td>
            </tr>
            <tr>
                <td align="right" valign="top">权限：</td>
                <td>
                    <ul class="group">
                        <?php foreach($nodes as $key=>$val){ ?>
                        <li class="item">
                            <span><?= $val['title']; ?></span>：
                            <?php
                            foreach($val['nodes'] as $k=>$v){
                                $attr = (is_array($rights) && array_key_exists($key, $rights) && in_array($k, $rights[$key])) ? 'checked' : ''; 
                            ?>
                            <label><input type="checkbox" name="rights[<?= $key; ?>][]" value="<?= $k; ?>" <?= $attr; ?>> <?= $v; ?></label>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                    <span id="checkAll" class="hand">全选</span> <span class="gray"> | </span> <span id="inverse" class="hand">反选</span> <span class="gray"> | </span> <span id="deselect" class="hand">取消</span>
                </td>
            </tr>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="reset" class="btn">重置</button></li>
            <li><button type="button" class="btn" onClick="history.back()">返回</button></li>
        </ul>
        <input type="hidden" name="id" value="<?= $data['id']; ?>">
    </form>
</div>
<script> var REMOTE_URL = "<?= url('User-check', $data['id']); ?>"; </script>
<script src="https://cdn.bootcss.com/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="<?php js('admin/js/user'); ?>"></script>