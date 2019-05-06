<div class="box">
    <div class="box-head">
        <div class="box-title"><a href="<?php echo BASE_URL; ?>" title="首页">首页</a><?php echo $path; ?></div>
    </div>
    <div class="box-body height-auto">
        <div class="product-info clearfix">
            <div class="product-photo">
                <div class="preview"><a id="Zoomer" href="<?php echo $data['img1']; ?>" rel="zoom-width:330px;zoom-height:290px;" class="MagicZoomPlus"><img src="<?php echo $data['img2']; ?>" width="320" height="240"></a></div>
                <div id="gallery" class="gallery">
                    <div class="gallery-container">
                        <ul class="gallery-list">
                            <li class="gallery-item"><a href="<?php echo $data['img1']; ?>" rel="zoom-id:Zoomer" rev="<?php echo $data['img2']; ?>"><img src="<?php echo $data['img2']; ?>"></a></li>
                            <?php if($data['album']){ ?>
                                <?php $album = json_decode($data['album'], true); foreach($album as $acc){ ?>
                                <li class="gallery-item"><a href="<?php echo $acc['img1']; ?>" rel="zoom-id:Zoomer" rev="<?php echo $acc['img2']; ?>"><img src="<?php echo $acc['img2']; ?>"></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="gallery-arrow gallery-prev disabled">&lt;</div>
                    <div class="gallery-arrow gallery-next disabled">&gt;</div>
                </div>
            </div>
            <div class="product-attr">
                <h2 class="product-name"><?php echo $data['name'];?></h2>
                <table class="layout">
                    <tr>
                        <td width="80" align="right">产品名称：</td>
                        <td><?php echo $data['name'];?></td>
                    </tr>
                    <tr>
                        <td align="right">产品型号：</td>
                        <td><?php echo isset($attr['model']) ? $attr['model'] : '';?></td>
                    </tr>
                    <tr>
                        <td align="right">产品规格：</td>
                        <td><?php echo isset($attr['specification']) ? $attr['specification'] : ''; ?></td>
                    </tr>
                </table>
                <div class="product-but"><button id="inquiryBtn" class="button">我要询价</button></div>
            </div>
        </div>
        <div class="content">
            <div class="product-desc">产品描述</div>
            <div class="editor product-content"><?php echo $this->filter($data['content']); ?></div>
            <?php if($prev || $next){ ?>
            <div class="boxoff"><b></b></div>
            <ul class="context">
                <?php if($prev){ ?>
                <li class="context-prev"><a href="<?php echo url('product-item', $prev['id']); ?>">上一个：<?php echo $prev['name']; ?></a></li>
                <?php } ?>
                <?php if($next){ ?>
                <li class="context-next"><a href="<?php echo url('product-item', $next['id']); ?>">下一个：<?php echo $next['name']; ?></a></li>
                <?php } ?>
            </ul>
            <?php } ?>
        </div>
    </div>
</div>
<!--dialog-->
<div id="dialogMask" class="dialog-mask" style="display:none;"></div>
<div id="dialog" class="dialog" style="display:none;">
    <div class="dialog-header">
        <div class="dialog-title">在线询价</div>
        <button type="button" id="dialogClose" class="dialog-close" title="关闭">&times;</button>
    </div>
    <div class="dialog-center">
        <div class="inquiry">
            <p class="inquiry-hint">请留下你您的联系方式和需求，我们会及时联系您。</p>
            <form action="<?php echo url('message-insert'); ?>" method="post" id="messageForm">
                <table class="message" width="100%" cellspacing="5">
                    <tr>
                        <td width="90" align="right">公司名称：</td>
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
                        <td><textarea id="textarea" name="message" style="width:450px;height:100px;" rows="6" title="请输入留言内容">本人有意向订购此产品，请联系我。</textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="type" value="1">
                            <input id="button" class="button" name="submit" type="submit" disabled="disabled" value="提交">
                            <span id="preloader" class="preloader" style="display:none;"></span>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<!--/dialog-->
<link rel="stylesheet" href="<?php css('common/magiczoomplus/magiczoomplus'); ?>">
<script src="<?php echo src('common/magiczoomplus/magiczoomplus.min.js'); ?>"></script>
<script src="https://cdn.bootcss.com/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="<?php js('home/js/product'); ?>"></script>