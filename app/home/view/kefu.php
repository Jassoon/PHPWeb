<style scoped="scoped">
    .kefu { position: fixed; top: 20%; right: 10px; }
    .kefu-side { line-height: 1.5; color: #fff; padding: 6px; background-color: #34a150; cursor: pointer; }
    .kefu-side:hover { background-color: #278f41; }
    .kefu-main { width: 126px; background: #fff; border: solid 1px #34a150; }
    .kefu-head { font-size: 14px; color: #FFF; padding-left: 12px; background-color: #278f41; border-bottom: solid 1px #34a150; position: relative; }
    .kefu-close { font-size: 21px; line-height: 23px; text-align: center; width: 28px; height: 28px; opacity: 0.5; position: absolute; top: 0; right: 0; cursor: pointer; }
    .kefu-close:hover { opacity: 1; }
    .kefu-body { font-size: 12px; padding: 6px 12px; }
    .kefu-item { line-height: 1.5; padding: 6px 0; }
</style>
<div id="kefu" class="kefu">
    <div id="kefuSide" class="kefu-side">在<br/>线<br/>咨<br/>询</div>
    <div id="kefuMain" class="kefu-main" style="display:none;">
        <div class="kefu-head">
            <div class="kefu-title">在线咨询</div>
            <div id="kefuClose" class="kefu-close" title="关闭">&times;</div>
        </div>
        <div id="kefuBody" class="kefu-body"></div>
    </div>
</div>
<script type="text/html" id="kefuTpl">
<?php $kefu = $this->getKefuList(); if($kefu){ ?>
    <?php foreach($kefu as $key=>$val){ ?>
    <dl class="kefu-item">
        <dt><?php echo $val['name']; ?></dt>
        <dd>
            <?php if($val['type'] == 0){ ?>
                <a target="_blank" href="//wpa.qq.com/msgrd?v=3&uin=<?php echo $val['account']; ?>&site=qq&menu=yes"><img width="79" height="25" src="//wpa.qq.com/pa?p=2:<?php echo $val['account']; ?>:51" alt="<?php echo $val['name']; ?>" title="<?php echo $val['name']; ?>"></a>
            <?php }elseif($val['type'] == 1){ ?>
                <a target="_blank" href="skype:<?php echo $val['account']; ?>?chat"><img width="74" height="23" src="<?php echo src('home/image/skype.jpg'); ?>" alt="<?php echo $val['name']; ?>" title="<?php echo $val['name']; ?>"></a>
            <?php }else if($val['type'] == 2){ ?>
                <a target="_blank" href="//www.taobao.com/webww/ww.php?ver=3&touid=<?php echo $val['account']; ?>&siteid=cntaobao&status=1&charset=utf-8"><img width="74" height="23" src="<?php echo src('home/image/wangwang.jpg'); ?>" alt="<?php echo $val['name']; ?>" title="<?php echo $val['name']; ?>"></a>
            <?php }else if($val['type'] == 3){ ?>
                <?php echo $val['account']; ?>
            <?php } ?>
        </dd>
    </dl>
    <?php } ?>
<?php } ?>
</script>
<script>
    $(function ($) {
        var kefuSide = $('#kefuSide'),
            kefuMain = $('#kefuMain'),
            kefuBody = $('#kefuBody'),
            kefuTpl = $('#kefuTpl'),
            ready = false;

        kefuSide.on('click', function () {
            if (!ready) {
                kefuBody.html(kefuTpl.html());
                ready = true;
            }
            kefuSide.hide();
            kefuMain.show();
        });

        $('#kefuClose').on('click', function () {
            kefuSide.show();
            kefuMain.hide();
        });
    });
</script>