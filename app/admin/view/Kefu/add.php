<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">添加客服</a></li>
        <li class="tab-item"><a href="<?php echo url('Kefu'); ?>">客服列表</a></li>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('Kefu-insert'); ?>" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">类型：</td>
                <td>
                    <select name="type">
                        <?php
                        $kefuType = C('KEFU_TYPE');
                        foreach($kefuType as $key=>$val){
                        ?>
                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                        <?php } ?>
                    </select>
                    <a class="gray" href="//shang.qq.com/v3/widget/consult.html" target="_blank">开通QQ会话功能</a>
                </td>
            </tr>
            <tr>
                <td align="right">号码：</td>
                <td><input class="ime" name="account" type="text" size="38" autofocus required title="客服号码"></td>
            </tr>
            <tr>
                <td align="right">名称：</td>
                <td><input name="name" type="text" size="38" required title="请输入客服名称"></td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo D('kefu')->getAutoincrement(); ?>" size="6" maxlength="6">
                    <span class="separator">|</span>
                    <label><input name="is_show" type="checkbox" value="1" checked="checked"> 前台显示</label>
                </td>
            </tr>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="reset" class="btn">重置</button></li>
            <li><button type="button" class="btn" onClick="history.back()">返回</button></li>
        </ul>
    </form>
</div>
<script src="<?php js('admin/js/kefu'); ?>"></script>