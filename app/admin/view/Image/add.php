<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">添加图片</a></li>
        <li class="tab-item"><a href="<?php echo url('Image'); ?>">图片列表</a></li>
    </ul>
</div>
<div class="content">
    <div class="preview"><img id="img" src="<?php echo src('admin/image/pic.png'); ?>"></div>
    <form action="<?php echo url('Image-insert'); ?>" method="post">
        <table class="edit">
            <tr>
                <td width="60" align="right">图片：</td>
                <td>
                    <span id="upload" class="ajax-upload-btn">上传图片</span><span class="loading"></span>
                    <span class="gray">格式：jpg,png,gif</span>
                    <input name="img" type="hidden">
                </td>
            </tr>
            <tr>
                <td align="right">标题：</td>
                <td><input name="title" type="text" size="50" autofocus></td>
            </tr>
            <tr>
                <td align="right">链接：</td>
                <td><input name="url" type="text" class="ime" size="50"></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td>
                    <select name="cat">
                        <?php
                        $category = C('IMAGE_CATEGORY');
                        foreach($category as $key=>$val){
                        ?>
                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo D('image')->getAutoincrement(); ?>" size="1">
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
<script src="<?php js('admin/js/ajaxUpload') ?>"></script>
<script src="<?php js('admin/js/image'); ?>"></script>