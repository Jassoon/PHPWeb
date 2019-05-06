<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><span class="gt"> &gt;&gt; </span>404</div>
    </div>
    <div class="box-body height-auto">
        <div class="empty">很抱歉，您访问的页面不存在！</div>
    </div>
</div>
<script>
    setTimeout(function(){
        window.location.replace('<?php echo BASE_URL; ?>');
    }, 3000);
</script>