<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?php echo url('Article-add'); ?>">添加文章</a></li>
        <li class="tab-item"><a href="<?php echo url('Article'); ?>">文章列表</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">编辑文章</a></li>
    </ul>
    <ul class="context">
        <li><?php if($prev){ ?><a href="<?php echo url('Article-edit', $prev['id']) ?>" data-target="replace">上一条</a><?php } ?></li>
        <li><?php if($next){ ?><a href="<?php echo url('Article-edit', $next['id']) ?>" data-target="replace">下一条</a><?php } ?></li>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('Article-update'); ?>" method="post">
        <table class="edit">
            <tr>
                <td width="60" align="right">标题：</td>
                <td><input name="title" type="text" value="<?php echo $data['title']; ?>" size="100" autofocus required title="请输入标题"></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td>
                    <select name="cat"><?php option($category, 'id', 'cat_name', $data['cat']); ?></select>
                    <span class="separator"> | </span> 排序
                    <input name="orderly" type="text" data-type="float" value="<?php echo $data['orderly']; ?>" size="6" maxlength="9">
                    <span class="separator"> | </span>
                    <label><?php checkbox('is_show', '1', $data['is_show']); ?> 前台显示</label>
                    <span class="separator"> | </span>
                    <label><?php checkbox('is_tj', '1', $data['is_tj']); ?> 首页显示</label>
                    <span class="separator"> | </span>
                    <label><input type="checkbox" data-details="#seo"> SEO优化选项</label>
                </td>
            </tr>
            <tbody id="seo" style="display:none">
                <tr>
                    <td align="right">作者：</td>
                    <td>
                        <input class="mr10" type="text" name="author" value="<?php echo $data['author']; ?>" size="30">
                        链接：
                        <input name="author_url" type="url" class="mr10" value="<?php echo $data['author_url']; ?>" size="30" placeholder="http://www.domain.com">
                        日期：
                        <input name="create_date" type="text" class="ime" maxlength="10" value="<?php echo $data['create_date']; ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">标题栏：</td>
                    <td><input name="title_bar" type="text" value="<?php echo $data['title_bar']; ?>"></td>
                </tr>
                <tr>
                    <td align="right">关健词：</td>
                    <td><input type="text" name="keywords" value="<?php echo $data['keywords']; ?>"></td>
                </tr>
                <tr>
                    <td align="right" valign="top">描述：</td>
                    <td><textarea name="description" rows="3"><?php echo $data['description']; ?></textarea></td>
                </tr>
            </tbody>
            <tr>
                <td align="right" valign="top">内容：</td>
                <td><textarea data-editor="default" name="content" style="width:100%; height:300px;"><?php echo $data['content']; ?></textarea></td>
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
<script src="<?php js('common/kindeditor/kindeditor'); ?>"></script>
<script src="<?php js('admin/js/article'); ?>"></script>