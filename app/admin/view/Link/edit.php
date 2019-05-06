<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?php echo url('Link-add'); ?>">添加链接</a></li>
        <li class="tab-item"><a href="<?php echo url('Link'); ?>">链接列表</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">编辑链接</a></li>
    </ul>
    <ul class="context">
        <li><?php if($prev){ ?><a href="<?php echo url('Link-edit', $prev['id']); ?>" data-target="replace">上一条</a><?php } ?></li>
        <li><?php if($next){ ?><a href="<?php echo url('Link-edit', $next['id']); ?>" data-target="replace">下一条</a><?php } ?></li>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('Link-update'); ?>" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">名称：</td>
                <td><input name="name" type="text" value="<?php echo $data['name'] ?>" size="38" autofocus required title="请输入链接名称"></td>
            </tr>
            <tr>
                <td align="right">地址：</td>
                <td><input class="ime" name="url" type="url" placeholder="http://www.domain.com" value="<?php echo $data['url'] ?>" size="38" required title="请输入链接地址"></td>
            </tr>
            <tr>
                <td align="right">描述：</td>
                <td><input name="title" type="text" value="<?php echo $data['title']?>" size="38"></td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo $data['orderly']; ?>" size="6" maxlength="6">
                    <span class="separator">|</span>
                    <label><?php checkbox('is_show', '1', $data['is_show']); ?> 前台显示</label>
                    <span class="separator">|</span>
                    <label><?php checkbox('is_tj', '1', $data['is_tj']); ?> 首页显示</label>
                </td>
            </tr>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="reset" class="btn">重置</button></li>
            <li><button type="button" class="btn" onClick="history.back()">返回</button></li>
        </ul>
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
    </form>
</div>
<script src="<?php js('admin/js/link'); ?>"></script>