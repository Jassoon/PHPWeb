<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?php echo url('Photo-add'); ?>">添加照片</a></li>
        <li class="tab-item"><a href="<?php echo url('Photo'); ?>">照片列表</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">编辑照片</a></li>
    </ul>
    <ul class="context">
        <li><?php if($prev){ ?><a href="<?php echo url('Photo-edit', $prev['id']); ?>" data-target="replace">上一条</a><?php } ?></li>
        <li><?php if($next){ ?><a href="<?php echo url('Photo-edit', $next['id']); ?>" data-target="replace">下一条</a><?php } ?></li>
    </ul>
</div>
<div class="content">
    <div class="preview"><a id="img1" rel="fancybox" href="<?php echo $data['img1']; ?>"><img id="img2" src="<?php echo $data['img2']; ?>"></a></div>
    <form action="<?php echo url('Photo-update'); ?>" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">图片：</td>
                <td>
                    <span id="upload" class="ajax-upload-btn">上传图片</span><span class="loading"></span>
                    <span class="gray">格式:jpg, png, gif</span>
                    <input name="img1" type="hidden" value="<?php echo $data['img1'];?>">
                    <input name="img2" type="hidden" value="<?php echo $data['img2'];?>">
                </td>
            </tr>
            <tr>
                <td align="right">标题：</td>
                <td><input name="title" type="text" value="<?php echo $data['title'];?>" size="38" autofocus required></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td><select name="cat"><?php option($category, 'id', 'cat_name', $data['cat']) ?></select></td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo $data['orderly'] ?>" size="6" maxlength="9">
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
<script src="<?php js('admin/js/ajaxUpload'); ?>"></script>
<script src="<?php js('admin/js/photo'); ?>"></script>