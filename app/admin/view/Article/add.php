<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">添加文章</a></li>
        <li class="tab-item"><a href="<?php echo url('Article'); ?>">文章列表</a></li>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('Article-insert'); ?>" method="post">
        <table class="edit" align="center">
            <tr>
                <td align="right" width="60">标题：</td>
                <td><input name="title" type="text" size="100" autofocus required title="请输入标题"></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td>
                    <select name="cat"><?php option($category, 'id', 'cat_name'); ?></select>
                    <span class="separator"> | </span> 排序
                    <input name="orderly" type="text" data-type="float" value="<?php echo D('article')->getAutoincrement(); ?>" size="6" maxlength="9">
                    <span class="separator"> | </span>
                    <label><input name="is_show" type="checkbox" value="1" checked="checked"> 前台显示</label>
                    <span class="separator"> | </span>
                    <label><input name="is_tj" type="checkbox" value="1" checked="checked"> 首页显示</label>
                    <span class="separator"> | </span>
                    <label><input type="checkbox" data-details="#seo"> SEO优化选项</label>
                </td>
            </tr>
            <tbody id="seo" style="display:none">
                <tr>
                    <td align="right">作者：</td>
                    <td>
                        <input name="author" type="text" class="mr10" size="30">
                        链接：
                        <input name="author_url" type="url" class="mr10" size="30" placeholder="http://www.domain.com">
                        日期：
                        <input name="create_date" type="text" class="ime" maxlength="10" value="<?php echo date('Y-m-d') ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">标题栏：</td>
                    <td><input type="text" name="title_bar"></td>
                </tr>
                <tr>
                    <td align="right">关健词：</td>
                    <td><input type="text" name="keywords"></td>
                </tr>
                <tr>
                    <td align="right" valign="top">描述：</td>
                    <td><textarea name="description" rows="3"></textarea></td>
                </tr>
            </tbody>
            <tr>
                <td align="right" valign="top">内容：</td>
                <td><textarea data-editor="default" name="content" style="width:100%; height:300px;"></textarea></td>
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
<script src="<?php js('admin/js/article'); ?>"></script>