<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">添加产品</a></li>
        <li class="tab-item"><a href="<?php echo url('Product'); ?>">产品列表</a></li>
    </ul>
</div>
<div class="content">
    <div class="image-demo"><a id="img1" href="<?php echo src('admin/image/pic.png'); ?>" rel="fancybox"><img id="img2" src="<?php echo src('admin/image/pic.png'); ?>"></a></div>
    <form action="<?php echo url('Product-insert'); ?>" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">图片：</td>
                <td>
                    <span id="upload" class="ajax-upload-btn">上传图片</span><span class="loading"></span>
                    <span class="gray">格式:jpg, png, gif</span>
                    <input type="hidden" name="img1">
                    <input type="hidden" name="img2">
                </td>
            </tr>
            <tr>
                <td align="right">名称：</td>
                <td><input name="name" type="text" size="80" autofocus required></td>
            </tr>
            <tr>
                <td align="right">型号：</td>
                <td><input name="attr[model]" type="text" size="80"></td>
            </tr>
            <tr>
                <td align="right">规格：</td>
                <td><input name="attr[specification]" type="text" size="80"></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td>
                    <select name="cat"><?php $tree->option(); ?></select>
                    <span class="separator">|</span> 排序
                    <input name="orderly" type="text" data-type="float" value="<?php echo D('product')->getAutoincrement(); ?>" size="6" maxlength="9">
                    <span class="separator">|</span>
                    <label><input name="is_show" type="checkbox" value="1" checked="checked"> 前台显示</label>
                    <span class="separator">|</span>
                    <label><input name="is_tj" type="checkbox" value="1" checked="checked"> 首页显示</label>
                    <span class="separator">|</span>
                    <label><input type="checkbox" data-details="#more"> SEO优化选项</label>
                </td>
            </tr>
            <tbody id="more" style="display:none;">
                <tr>
                    <td align="right">标题栏：</td>
                    <td><input name="title_bar" type="text"></td>
                </tr>
                <tr>
                    <td align="right">关健字：</td>
                    <td><input name="keywords" type="text"></td>
                </tr>
                <tr>
                    <td align="right" valign="top">描述：</td>
                    <td><textarea name="description" rows="3"></textarea></td>
                </tr>
            </tbody>
            <tr>
                <td align="right" valign="top">照片：</td>
                <td>
                    <div>
                        <span id="albumUpload" class="ajax-upload-btn">上传照片</span><span class="loading"></span>
                        <span class="gray">格式:jpg, png, gif</span>
                    </div>
                    <ul id="album" class="album"></ul>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">内容：</td>
                <td><textarea name="content" data-editor="default" style="width:100%; height:300px;"></textarea></td>
            </tr>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="reset" class="btn">重置</button></li>
            <li><button type="button" class="btn" onClick="history.back()">返回</button></li>
        </ul>
    </form>
</div>
<script src="<?php js('common/kindeditor/kindeditor'); ?>"></script>
<script src="<?php echo src('common/jquery.dragsort.min.js'); ?>"></script>
<script src="<?php js('admin/js/ajaxUpload'); ?>"></script>
<script src="<?php js('admin/js/product'); ?>"></script>