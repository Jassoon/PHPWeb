<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">添加文件</a></li>
        <li class="tab-item"><a href="<?php echo url('File'); ?>">文件列表</a></li>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('File-insert'); ?>" method="post">
        <table class="edit">
            <tr>
                <td width="60" align="right">文件：</td>
                <td>
                    <span id="upload" class="ajax-upload-btn">上传文件</span><span class="loading"></span>
                    <span class="gray">格式:rar,zip,7z,doc,xls,ppt,pdf，大小不超过:<?php echo ini_get('upload_max_filesize') ?></span>
                </td>
            </tr>
            <tr>
                <td align="right">文件：</td>
                <td><input id="file" type="text" name="file" size="60"></td>
            </tr>
            <tr>
                <td align="right" width="60">名称：</td>
                <td>
                    <input name="title" type="text" size="60" required>
                    <span class="gray">名称不能包含 \ / : * ? &quot; &lt; &gt; | 等特殊字符</span>
                </td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td><select name="cat"><?php option($category, 'id', 'cat_name'); ?></select></td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo D('file')->getAutoincrement(); ?>" size="6" maxlength="6">
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
<script src="<?php js('admin/js/file'); ?>"></script>