<?php $content = json_decode($data['content'], true); ?>
<style scoped>
@media print {
.tab-bar, .but-bar { display: none; }
.edit { border-collapse: collapse; }
.edit td { border: solid #ccc 1px; }
}
</style>
<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item"><a href="<?php echo url('Message'); ?>">留言列表</a></li>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">查看留言</a></li>
    </ul>
    <table class="context">
        <tr>
            <td><?php if($prev){ ?><a href="<?php echo url('Message-item', $prev['id']); ?>" <?php if($prev['is_read']==0){echo 'class="blue"';} ?> data-target="replace">上一条</a><?php } ?></td>
            <td><?php if($next){ ?><a href="<?php echo url('Message-item', $next['id']); ?>" <?php if($next['is_read']==0){echo 'class="blue"';} ?> data-target="replace">下一条</a><?php } ?></td>
        </tr>
    </table>
</div>
<div class="content">
    <table class="edit">
        <tr>
            <td width="60" align="right">公司名称：</td>
            <td><?php echo $content['company']; ?></td>
        </tr>
        <tr>
            <td align="right">联系人：</td>
            <td><?php echo $content['contact_person']; ?></td>
        </tr>
        <tr>
            <td align="right">电话：</td>
            <td><?php echo $content['phone']; ?></td>
        </tr>
        <tr>
            <td align="right">邮箱：</td>
            <td><?php echo $content['email']; ?></td>
        </tr>
        <tr>
            <td align="right" valign="top">留言：</td>
            <td style="white-space:normal;">
                <?php
                $pattern = '/(https?:\/\/([\da-z-\.]+)(\.[a-z]{2,6})?([\/\w \.-?&%-]*)*\/?)/';
                $replacement = '<a class="blue" href="$1" target="_blank">$1</a>';
                echo nl2br(preg_replace($pattern, $replacement, $content['message']));
                ?>
            </td>
        </tr>
        <tr>
            <td align="right">留言时间：</td>
            <td><?php echo date('Y-m-d H:i:s', $data['create_time']); ?></td>
        </tr>
    </table>
    <ul class="tool-bar">
        <li><button type="button" class="btn" onClick="history.back()">返回</button></li>
        <li><button type="button" class="btn" onClick="window.print()">打印</button></li>
    </ul>
</div>