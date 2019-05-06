<?php $setting = setting(); ?>
<style scoped="scoped">
label ~ label { margin-left: 10px; }
.edit { margin-bottom: 30px; }
caption { border-bottom: dotted 1px #e2e2e2; text-align: left; font-size: 16px; text-indent: 15px; }
#grid { width: 400px; border-collapse: collapse; table-layout: fixed; }
#grid td { padding: 2px 5px; border: 1px solid #ddd; background: #f8f8f8; }
</style>
<div class="tab-bar">
    <ul class="tab">
        <?php foreach($this->navList as $key=>$val){ ?>
            <?php if($this->auth('Setting', $key)){ ?>
            <li class="tab-item <?php if(ACTION === $key){ echo ' current'; } ?>"><a href="<?php echo url('Setting', $key); ?>"><?php echo $val; ?></a></li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('Setting-update'); ?>" id="ajaxForm">
        <?php if($this->auth('Article')){ ?>
        <table class="edit">
            <caption>
            文章设置
            </caption>
            <tr>
                <td align="right" width="150">排序方式：</td>
                <td>
                    <label> <?php radio('article_order', 'DESC', $setting['article_order']); ?> 从大到小</label>
                    <label><?php radio('article_order', 'ASC', $setting['article_order']); ?> 从小到大</label>
                </td>
            </tr>
            <tr>
                <td align="right">每页显示：</td>
                <td><input name="article_count" type="number" min="1" class="ime" value="<?php echo $setting['article_count']; ?>" maxlength="3"> 条数据</td>
            </tr>
        </table>
        <!--/文章设置-->
        <?php } ?>
        <?php if($this->auth('Product')){ ?>
        <table class="edit">
            <caption>
            产品设置
            </caption>
            <tr>
                <td align="right" width="150">排序方式：</td>
                <td>
                    <label><?php radio('product_order', 'DESC', $setting['product_order']); ?> 从大到小</label>
                    <label><?php radio('product_order', 'ASC', $setting['product_order']); ?> 从小到大</label>
                </td>
            </tr>
            <tr>
                <td align="right">每页显示：</td>
                <td><input name="product_count" type="number" min="1" class="ime" value="<?php echo $setting['product_count']; ?>" maxlength="3"> 条数据</td>
            </tr>
        </table>
        <!--/产品设置-->
        <?php } ?>
        <?php if($this->auth('Photo')){ ?>
        <table class="edit">
            <caption>
            相册设置
            </caption>
            <tr>
                <td align="right" width="150">排序方式：</td>
                <td>
                    <label><?php radio('photo_order', 'DESC', $setting['photo_order']); ?> 从大到小</label>
                    <label><?php radio('photo_order', 'ASC', $setting['photo_order']); ?> 从小到大</label>
                </td>
            </tr>
            <tr>
                <td align="right">每页显示：</td>
                <td><input name="photo_count" type="number" min="1" class="ime" value="<?php echo $setting['photo_count']; ?>" maxlength="3"> 条数据</td>
            </tr>
        </table>
        <!--/相册设置-->
        <?php } ?>
        <?php if($this->auth('File')){ ?>
        <table class="edit">
            <caption>
            文件设置
            </caption>
            <tr>
                <td align="right" width="150">排序方式：</td>
                <td>
                    <label><?php radio('file_order', 'DESC', $setting['file_order']); ?> 从大到小</label>
                    <label><?php radio('file_order', 'ASC', $setting['file_order']); ?> 从小到大</label>
                </td>
            </tr>
            <tr>
                <td align="right">每页显示：</td>
                <td><input name="file_count" type="number" min="1" class="ime" value="<?php echo $setting['file_count']; ?>" maxlength="3"> 条数据</td>
            </tr>
        </table>
        <!--/文件设置-->
        <?php } ?>
        <?php if($this->auth('Kefu')){ ?>
        <table class="edit">
            <caption>
            客服设置
            </caption>
            <tr>
                <td align="right" width="150">在线客服：</td>
                <td>
                    <label><?php radio('kefu', '1', $setting['kefu']); ?> 开启</label>
                    <label><?php radio('kefu', '0', $setting['kefu']); ?> 关闭</label>
                </td>
            </tr>
        </table>
        <!--/客服设置-->
        <?php } ?>
        <table class="edit">
            <caption>
            水印设置
            </caption>
            <tr>
                <td align="right" width="150">水印功能：</td>
                <td>
                    <label><?php radio('watermark', '1', $setting['watermark']); ?> 开启</label>
                    <label><?php radio('watermark', '0', $setting['watermark']); ?> 关闭</label>
                </td>
            </tr>
            <tbody id="watermarkSettings" style="display:<?php if($setting['watermark']===0){ echo 'none'; } ?>">
                <tr>
                    <td align="right">水印图片：</td>
                    <td><span class="img-wrap"><img src="<?php echo $setting['watermark_img']?:src('admin/image/null.gif'); ?>" id="watermarkShow"></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <span id="upload" class="ajax-upload-btn">上传图片</span><span class="loading"></span>
                        <span class="gray">图像格式:jpg, png, gif</span>
                        <input name="watermark_img" type="hidden" value="<?php echo $setting['watermark_img']; ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top">水印位置：</td>
                    <td>
                        <table id="grid">
                            <tr>
                                <td><label><?php radio('watermark_position', '1', $setting['watermark_position']); ?> 顶部居左</label></td>
                                <td><label><?php radio('watermark_position', '2', $setting['watermark_position']); ?> 顶部居中</label></td>
                                <td><label><?php radio('watermark_position', '3', $setting['watermark_position']); ?> 顶部居右</label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label><?php radio('watermark_position', '4', $setting['watermark_position']); ?> 左边居中</label></td>
                                <td><label><?php radio('watermark_position', '5', $setting['watermark_position']); ?> 图片中心</label></td>
                                <td><label><?php radio('watermark_position', '6', $setting['watermark_position']); ?> 右边居中</label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label><?php radio('watermark_position', '7', $setting['watermark_position']); ?> 底部居左</label></td>
                                <td><label><?php radio('watermark_position', '8', $setting['watermark_position']); ?> 底部居中</label></td>
                                <td><label><?php radio('watermark_position', '9', $setting['watermark_position']); ?> 底部居右</label></td>
                                <td><label><?php radio('watermark_position', '0', $setting['watermark_position']); ?> 随机位置</label></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="button" class="btn" onClick="location.reload()">重置</button></li>
        </ul>
    </form>
</div>
<script src="<?php js('admin/js/ajaxUpload'); ?>"></script>
<script src="<?php js('admin/js/setting_rule'); ?>"></script>