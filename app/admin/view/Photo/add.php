<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">添加照片</a></li>
        <li class="tab-item"><a href="<?php echo url('Photo'); ?>">照片列表</a></li>
    </ul>
</div>
<div class="content">
    <div class="preview"><a id="img1" rel="fancybox" href="<?php echo src('admin/image/pic.png'); ?>"><img id="img2" src="<?php echo src('admin/image/pic.png'); ?>"></a></div>
    <form action="<?php echo url('Photo-insert'); ?>" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">图片：</td>
                <td>
                    <span id="upload" class="ajax-upload-btn">上传图片</span><span class="loading"></span>
                    <span class="gray">格式:jpg, png, gif</span>
                    <input name="img1" type="hidden">
                    <input name="img2" type="hidden">
                </td>
            </tr>
            <tr>
                <td align="right">标题：</td>
                <td><input name="title" type="text" size="38" autofocus required></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td><select name="cat"><?php option($category, 'id', 'cat_name'); ?></select></td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo D('photo')->getAutoincrement(); ?>" size="6" maxlength="9">
                    <span class="separator">|</span>
                    <label><input name="is_show" type="checkbox" value="1" checked="checked"> 前台显示</label>
                    <span class="separator">|</span>
                    <label><input name="is_tj" type="checkbox" value="1" checked="checked"> 首页显示</label>
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
<script src="<?php js('admin/js/ajaxUpload'); ?>"></script>
<script src="<?php js('admin/js/photo'); ?>"></script>