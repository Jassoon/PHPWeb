<div class="tab-bar">
    <ul class="tab">
        <?php if($this->auth(CONTROLLER, 'add')){ ?>
        <li class="tab-item"><a href="<?php echo url('Image-add'); ?>">添加图片</a></li>
        <?php } ?>
        <li class="tab-item"><a href="<?php echo url('Image'); ?>">图片列表</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">编辑图片</a></li>
    </ul>
    <ul class="context">
        <li><?php if($prev){ ?><a href="<?php echo url('Image-edit', $prev['id']); ?>" data-target="replace">上一条</a><?php } ?></li>
        <li><?php if($next){ ?><a href="<?php echo url('Image-edit', $next['id']); ?>" data-target="replace">下一条</a><?php } ?></li>
    </ul>
</div>
<div class="content">
    <div class="preview"><img id="img" src="<?php echo $data['img']; ?>"></div>
    <form action="<?php echo url('Image-update'); ?>" method="post">
        <table class="edit">
            <tr>
                <td width="60" align="right">图片：</td>
                <td>
                    <span id="upload" class="ajax-upload-btn">上传图片</span><span class="loading"></span>
                    <span class="gray">格式：jpg,png,gif</span>
                    <input name="img" type="hidden" value="<?php echo $data['img']; ?>">
                </td>
            </tr>
            <tr>
                <td align="right">标题：</td>
                <td><input name="title" type="text" value="<?php echo $data['title'] ?>" size="50" autofocus></td>
            </tr>
            <tr>
                <td align="right">链接：</td>
                <td><input name="url" type="text" class="ime" value="<?php echo $data['url'] ?>" size="50"></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td>
                    <select name="cat">
                        <?php
                        $category = C('IMAGE_CATEGORY');
                        foreach($category as $key=>$val){
                            if($key == $data['cat']){
                                echo "<option value='{$key}' selected='selected'>{$val}</option>";
                            }else{
                                echo "<option value='{$key}'>{$val}</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">排序：</td>
                <td>
                    <input name="orderly" type="text" data-type="float" value="<?php echo $data['orderly'] ?>" size="1">
                    <span class="separator">|</span>
                    <label><?php checkbox('is_show', '1', $data['is_show']); ?> 前台显示</label>
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
<script src="<?php js('admin/js/image'); ?>"></script>