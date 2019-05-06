<?php $setting = setting(); ?>
<style scoped="scoped">
.section { margin-bottom:10px; }
.title strong { font-size:14px; }
</style>
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
        <div class="section">
            <div class="title">
                <strong>页头代码</strong>
                <span class="gray">(页头代码输出在head结束标签前，一般用来添加mate标签以及需要添加在head内的代码)</span>
            </div>
            <textarea id="codeHeader" name="code_header" style="width:680px; height:200px;"><?php echo $setting['code_header']; ?></textarea>
        </div>
        <div class="section">
            <div class="title">
                <strong>页脚代码</strong>
                <span class="gray">(页脚代码输出在body结束标签前，一般用于放置第三方流量统计、在线客服、分享等功能代码)</span>
            </div>
            <textarea id="codeFooter" name="code_footer" style="width:680px; height:200px;"><?php echo $setting['code_footer']; ?></textarea>
        </div>
        <ul class="tool-bar">
            <li><button type="submit" name="submit" class="btn btn-blue">保存</button></li>
            <li><button type="button" class="btn" onClick="location.reload()">重置</button></li>
        </ul>
    </form>
</div>
