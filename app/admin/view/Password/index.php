<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">修改密码</a></li>
    </ul>
</div>
<div class="content">
    <form id="form" action="<?php echo url('Password-update'); ?>">
        <table class="edit">
            <tr>
                <td align="right" width="60">帐号：</td>
                <td><input type="text" disabled="disabled" value="<?php echo $_SESSION['user']['account']; ?>"></td>
            </tr>
            <tr>
                <td align="right">原密码：</td>
                <td><input name="old" type="password" autocomplete="off" class="ime" maxlength="16" autofocus required pattern="^[A-Za-z0-9_\-.]{4,16}$"></td>
            </tr>
            <tr>
                <td align="right">新密码：</td>
                <td><input name="password" type="password" autocomplete="off" class="ime" maxlength="16" required pattern="^[A-Za-z0-9_\-.]{4,16}$"></td>
            </tr>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="reset" class="btn">重置</button></li>
        </ul>
    </form>
</div>
<script>var LOGIN_URL = "<?php echo url('login'); ?>";</script>
<script src="<?php js('admin/js/password'); ?>"></script>