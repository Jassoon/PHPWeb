<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><span class="gt"> &gt;&gt; </span>客户留言</div>
    </div>
    <div class="box-body height-auto">
        <br>
        <form method="post" id="messageForm" action="<?php echo url('message-insert'); ?>">
            <table class="message" align="center" cellspacing="5">
                <tr>
                    <td align="right">公司名称：</td>
                    <td><input name="company" type="text" size="50" required title="请输入公司名称"></td>
                </tr>
                <tr>
                    <td align="right">联系人：</td>
                    <td><input name="contact_person" type="text" size="50" required title="请输入联系人"></td>
                </tr>
                <tr>
                    <td align="right">电话：</td>
                    <td><input name="phone" type="tel" size="50" required title="请输入电话"></td>
                </tr>
                <tr>
                    <td align="right">邮箱：</td>
                    <td><input name="email" type="email" size="50" required></td>
                </tr>
                <tr>
                    <td align="right" valign="top">留言：</td>
                    <td><textarea name="message" style="width:450px;" rows="6"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="type" value="0">
                        <button type="submit" id="button" class="button" name="submit" disabled="disabled">提交</button>
                        <span id="preloader" class="preloader" style="display:none;"></span>
                    </td>
                </tr>
            </table>
        </form>
        <br>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="<?php js('home/js/message'); ?>"></script>