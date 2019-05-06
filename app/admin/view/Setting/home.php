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
                <td align="right" width="80">首页标题栏：</td>
                <td><input type="text" name="title_bar" style="width:525px;" value="<?php echo $setting['title_bar']; ?>" autofocus></td>
            </tr>
            <tr>
                <td align="right" valign="top">首页描述：</td>
                <td><textarea name="description" style="width:525px;" rows="3"><?php echo $setting['description']; ?></textarea></td>
            </tr>
            <tr>
                <td align="right" valign="top">首页关健词：</td>
                <td><textarea name="keywords" style="width:525px;" rows="3"><?php echo $setting['keywords']; ?></textarea></td>
            </tr>
            <tr>
                <td align="right" valign="top">公司简介：</td>
                <td><textarea name="about" data-editor="simple" style="width:530px; height:200px;"><?php echo $setting['about']; ?></textarea></td>
            </tr>
        </table>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="button" class="btn" onClick="location.reload()">重置</button></li>
        </ul>
    </form>
</div>
<script src="<?php js('common/kindeditor/kindeditor'); ?>"></script>