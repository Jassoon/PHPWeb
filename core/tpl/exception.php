<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>系统发生错误</title>
<style>
    body { font-family: "Microsoft YaHei", Arial, Helvetica, sans-serif; font-size: 16px; }
    .wrap { padding: 16px 40px; }
    .face { font-size: 100px; font-weight: normal; line-height: 120px; }
    dl { line-height: 2; }
</style>
</head>

<body>
<div class="wrap">
    <div class="face">:(</div>
    <h1><?php echo strip_tags($e['message']); ?></h1>
    <?php if (isset($e['file'])) { ?>
    <dl>
        <dt><strong>错误位置</strong></dt>
        <dd>FILE: <?php echo $e['file']; ?> &#12288;LINE: <?php echo $e['line']; ?></dd>
    </dl>
    <?php } ?>
    <?php if (isset($e['trace'])) { ?>
    <dl>
        <dt><strong>TRACE</strong></dt>
        <dd><?php echo nl2br($e['trace']); ?></dd>
    </dl>
    <?php } ?>
</div>
</body>
</html>