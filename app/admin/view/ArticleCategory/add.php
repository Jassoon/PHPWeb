<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">添加类别</a></li>
        <li class="tab-item"><a href="<?php echo url('ArticleCategory'); ?>">类别列表</a></li>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('ArticleCategory-insert'); ?>" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">名称：</td>
                <td><input name="cat_name" type="text" size="35" autofocus required title="请输入类别名称"></td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo D('article_category')->getAutoincrement(); ?>" size="6" maxlength="6">
                    <span class="separator"> | </span>
                    <label><input type="checkbox" data-details="#seo"> SEO优化选项</label>
                </td>
            </tr>
            <tbody id="seo" style="display:none">
                <tr>
                    <td align="right">标题栏：</td>
                    <td><input type="text" name="title_bar"></td>
                </tr>
                <tr>
                    <td align="right">关健词：</td>
                    <td><input name="keywords" type="text"></td>
                </tr>
                <tr>
                    <td align="right" valign="top">描述：</td>
                    <td><textarea name="description" rows="3"></textarea></td>
                </tr>
            </tbody>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="reset" class="btn">重置</button></li>
            <li><button type="button" class="btn" onClick="history.back()">返回</button></li>
        </ul>
    </form>
</div>
<script src="<?php js('admin/js/articleCategory'); ?>"></script>