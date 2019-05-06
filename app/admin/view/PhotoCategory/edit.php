<div class="tab-bar">
    <ul class="tab">
        <?php if($this->auth(CONTROLLER, 'add')){ ?>
        <li class="tab-item"><a href="<?php echo url('PhotoCategory-add'); ?>">添加类别</a></li>
        <?php } ?>
        <li class="tab-item"><a href="<?php echo url('PhotoCategory'); ?>">类别列表</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">编辑类别</a></li>
    </ul>
    <ul class="context">
        <li><?php if($prev){ ?><a href="<?php echo url('PhotoCategory-edit', $prev['id']); ?>" data-target="replace">上一条</a><?php } ?></li>
        <li><?php if($next){ ?><a href="<?php echo url('PhotoCategory-edit', $next['id']); ?>" data-target="replace">下一条</a><?php } ?></li>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('PhotoCategory-update'); ?>" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">名称：</td>
                <td><input name="cat_name" type="text"  value="<?php echo $data['cat_name'];?>" size="35" maxlength="30" autofocus required title="请输入类别名称"></td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo $data['orderly']; ?>" size="6" maxlength="6">
                    <span class="separator"> | </span>
                    <label><input type="checkbox" data-details="#seo"> SEO优化选项</label>
                </td>
            </tr>
            <tbody id="seo" style="display:none;">
                <tr>
                    <td align="right">标题栏：</td>
                    <td><input name="title_bar" type="text" value="<?php echo $data['title_bar']; ?>"></td>
                </tr>
                <tr>
                    <td align="right">关健词：</td>
                    <td><input name="keywords" type="text" value="<?php echo $data['keywords'];?>"></td>
                </tr>
                <tr>
                    <td align="right" valign="top">描述：</td>
                    <td><textarea name="description" rows="3"><?php echo $data['description'];?></textarea></td>
                </tr>
            </tbody>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="reset" class="btn">重置</button></li>
            <li><button type="button" class="btn" onClick="history.back()">返回</button></li>
        </ul>
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
    </form>
</div>
<script src="<?php js('admin/js/photoCategory'); ?>"></script>