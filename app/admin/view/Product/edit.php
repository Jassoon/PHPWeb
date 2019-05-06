<?php $attr = json_decode($data['attr'], true); ?>
<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?php echo url('Product-add'); ?>">添加产品</a></li>
        <li class="tab-item"><a href="<?php echo url('Product'); ?>">产品列表</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">编辑产品</a></li>
    </ul>
    <ul class="context">
        <li><?php if($prev){ ?><a href="<?php echo url('Product-edit', $prev['id']); ?>" data-target="replace">上一条</a><?php } ?></li>
        <li><?php if($next){ ?><a href="<?php echo url('Product-edit', $next['id']); ?>" data-target="replace">下一条</a><?php } ?></li>
    </ul>
</div>
<div class="content">
    <div class="image-demo"><a id="img1" href="<?php echo $data['img1']; ?>" rel="fancybox"><img id="img2" src="<?php echo $data['img2']; ?>"></a></div>
    <form action="<?php echo url('Product-update'); ?>" method="post">
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
                <td align="right">名称：</td>
                <td><input name="name" type="text" value="<?php echo $data['name'];?>" size="80" autofocus required></td>
            </tr>
            <tr>
                <td align="right">型号：</td>
                <td><input name="attr[model]" type="text" value="<?php echo isset($attr['model']) ? $attr['model'] : ''; ?>" size="80"></td>
            </tr>
            <tr>
                <td align="right">规格：</td>
                <td><input name="attr[specification]" type="text" value="<?php echo isset($attr['specification']) ? $attr['specification'] : ''; ?>" size="80"></td>
            </tr>
            <tr>
                <td align="right">类别：</td>
                <td>
                    <select name="cat"><?php echo $tree->option(0, $data['cat']); ?></select>
                    <span class="separator">|</span> 排序
                    <input name="orderly" type="text" data-type="float" value="<?php echo $data['orderly'] ?>" size="6" maxlength="9">
                    <span class="separator"> | </span>
                    <label><?php checkbox('is_show', '1', $data['is_show']); ?> 前台显示</label>
                    <span class="separator"> | </span>
                    <label><?php checkbox('is_tj', '1', $data['is_tj']); ?> 首页显示</label>
                    <span class="separator">|</span>
                    <label><input type="checkbox" data-details="#seo"> SEO优化选项</label>
                </td>
            </tr>
            <tbody id="seo" style="display:none;">
                <tr>
                    <td align="right">标题栏：</td>
                    <td><input name="title_bar" type="text" value="<?php echo $data['title_bar']; ?>"></td>
                </tr>
                <tr>
                    <td align="right">关健字：</td>
                    <td><input name="keywords" type="text" value="<?php echo $data['keywords'];?>"></td>
                </tr>
                <tr>
                    <td align="right" valign="top">描述：</td>
                    <td><textarea name="description" rows="3"><?php echo $data['description'];?></textarea></td>
                </tr>
            </tbody>
            <tr>
                <td align="right" valign="top">照片：</td>
                <td>
                    <div>
                        <span id="albumUpload" class="ajax-upload-btn">上传照片</span><span class="loading"></span>
                        <span class="gray">格式:jpg, png, gif</span>
                    </div>
                    <ul id="album" class="album">
                        <?php if($data['album']){ ?>
                        <?php $album = json_decode($data['album'], true); foreach($album as $key=>$val){ ?>
                        <li><img src="<?php echo $val['img2']; ?>"><span title="删除"></span>
                            <input type="hidden" name="album[<?php echo $key; ?>][img1]" value="<?php echo $val['img1']; ?>">
                            <input type="hidden" name="album[<?php echo $key; ?>][img2]" value="<?php echo $val['img2']; ?>">
                        </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">内容：</td>
                <td><textarea name="content" data-editor="default" style="width:100%; height:300px;" ><?php echo $data['content'];?></textarea></td>
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
<script src="<?php echo src('common/jquery.dragsort.min.js'); ?>"></script>
<script src="<?php js('admin/js/ajaxUpload'); ?>"></script>
<script src="<?php js('admin/js/product'); ?>"></script>