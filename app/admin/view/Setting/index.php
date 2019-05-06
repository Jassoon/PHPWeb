<?php $setting = setting(); ?>
<div class="tab-bar">
    <ul class="tab">
        <?php foreach($this->navList as $key=>$val){ ?>
            <?php if($this->auth('Setting', $key)){ ?>
            <li class="tab-item <?php if(ACTION === $key){ echo 'current'; } ?>"><a href="<?php echo url('Setting', $key); ?>"><?php echo $val; ?></a></li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>
<div class="content">
    <form action="<?php echo url('Setting-update'); ?>" id="ajaxForm">
        <table class="edit">
            <tr>
                <td align="right" width="80">网站名称：</td>
                <td><input type="text" name="site_name" style="width:525px;" value="<?php echo $setting['site_name']; ?>" autofocus></td>
            </tr>
            <tr>
                <td align="right">网站地址：</td>
                <td><input type="text" name="site_url" style="width:525px;" value="<?php echo $setting['site_url']; ?>"></td>
            </tr>
            <tr>
                <td align="right" valign="top">联系方式：</td>
                <td><textarea name="contact" data-editor="simple" style="width:530px; height:200px;"><?php echo $setting['contact']; ?></textarea></td>
            </tr>
            <tr>
                <td align="right" valign="top">网站底部：</td>
                <td><textarea name="footer" data-editor="simple" style="width:530px; height:200px;"><?php echo $setting['footer']; ?></textarea></td>
            </tr>
            <tr>
                <td align="right" valign="top">Logo：</td>
                <td>
                    <div style="margin-bottom:10px;"><span class="img-wrap"><img id="logo" src="<?php echo $setting['logo']; ?>"></span></div>
                    <div>
                        <span id="upload" class="ajax-upload-btn">上传图片</span><span class="loading"></span>
                        <span class="gray">格式:jpg, png, gif</span>
                        <input name="logo" type="hidden" value="<?php echo $setting['logo']; ?>">
                    </div>
                </td>
            </tr>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="button" class="btn" onClick="location.reload()">重置</button></li>
        </ul>
    </form>
</div>
<script src="<?php js('common/kindeditor/kindeditor'); ?>"></script>
<script src="<?php js('admin/js/ajaxUpload'); ?>"></script>
<script src="<?php js('admin/js/setting_base'); ?>"></script>