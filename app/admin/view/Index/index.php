<?php $statistics = import(MODULE_DIR . 'statistics.php'); ?>
<style scoped>
table { width: 100%; border-collapse: collapse; }
table th, table td { padding: 3px; text-indent: 10px; }
table th { background: #EFEFEF; text-align: left; }
</style>
<div class="content">
    <h3 style="padding-left:13px;"><span id="greet">您好</span>，<?php echo $_SESSION['user']['name']; ?></h3>
    <table>
        <tr>
            <th width="200">系统统计</th>
            <th></th>
        </tr>
        <?php foreach($statistics as $v){ ?>
            <?php if(empty($v['auth']) || $this->auth($v['auth'])){ ?>
        <tr>
            <td><?php echo $v['name']; ?></td>
            <td><span class="red"><?php echo D($v['table'])->getCount() ?></span></td>
        </tr>
            <?php } ?>
        <?php } ?>
        <tr>
            <th>技术支持</th>
            <th></th>
        </tr>
        <tr>
            <td>联系人：</td>
            <td>雷先生</td>
        </tr>
        <tr>
            <td>手机：</td>
            <td>13580301915</td>
        </tr>
        <tr>
            <td>QQ：</td>
            <td><a target="_blank" href="//wpa.qq.com/msgrd?v=3&uin=454097099&site=qq&menu=yes">454097099</a></td>
        </tr>
    </table>
</div>
<script src="<?php js('admin/js/main'); ?>"></script>