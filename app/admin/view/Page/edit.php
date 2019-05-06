<div class="tab-bar">
    <ul class="tab">
        <?php if($this->auth(CONTROLLER, 'add')){ ?>
        <li class="tab-item"><a href="<?php echo url('Page-add'); ?>">添加页面</a></li>
        <?php } ?>
        <li class="tab-item"><a href="<?php echo url('Page'); ?>">页面列表</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">编辑页面</a></li>
    </ul>
    <ul class="context">
        <li><?php if($prev){ ?><a href="<?php echo url('Page-edit', $prev['id']); ?>" data-target="replace">上一页</a><?php } ?></li>
        <li><?php if($next){ ?><a href="<?php echo url('Page-edit', $next['id']); ?>" data-target="replace">下一页</a><?php } ?></li>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('Page-update'); ?>" method="post">
        <table class="edit">
            <tr>
                <td align="right" width="60">标题：</td>
                <td><input name="title" type="text" value="<?php echo $data['title'];?>" size="60" autofocus required title="请输入标题"></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td>
                    <select name="cat">
                        <?php
                        $category = C('PAGE_CATEGORY');
                        foreach($category as $key=>$val){
                            if($key == $data['cat']){
                                echo "<option value='{$key}' selected='selected'>{$val}</option>";
                            }else{
                                echo "<option value='{$key}'>{$val}</option>";
                            }
                        }
                        ?>
                    </select>
                    <label><input type="checkbox" data-details="#seo">SEO优化选项</label>
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
            <tr>
                <td align="right" valign="top">内容：</td>
                <td><textarea name="content" data-editor="default" style="width:100%; height:360px;"><?php echo $data['content'];?></textarea></td>
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
<script src="<?php js('admin/js/page'); ?>"></script>