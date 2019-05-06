<div class="tab-bar">
    <ul class="tab">
        <?php if($this->auth(CONTROLLER, 'add')){ ?>
        <li class="tab-item"><a href="<?php echo url('Image-add'); ?>">添加图片</a></li>
        <?php } ?>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">图片列表</a></li>
    </ul>
</div>
<div class="content">
    <form>
        <div class="panel">
            <label class="mr10">
                类别：
                <select name="cat" id="category">
                    <option value="">全部类别</option>
                    <?php
                    $cat = get('cat');
                    $category = C('IMAGE_CATEGORY');
                    foreach($category as $key=>$val){
                        if($key === $cat){
                            echo "<option value='{$key}' selected='selected'>{$val}</option>";
                        }else{
                            echo "<option value='{$key}'>{$val}</option>";
                        }
                    } ?>
                </select>
            </label>
            <label>标题：<input name="title" type="search" value="<?php echo get('title'); ?>" size="30" results="s" x-webkit-grammar="builtin:translate" x-webkit-speech></label>
            <button type="submit" class="btn">开始搜索</button>
            <button type="button" class="btn" onClick="location.replace(location.pathname)">显示全部</button>
        </div>
    </form>
    <?php if($rows){ ?>
        <form method="post" id="listForm">
        <table class="list">
            <tr>
                <th width="30"><input id="checkAll" type="checkbox"></th>
                <th width="60">排序</th>
                <th width="*">标题</th>
                <th width="*">链接</th>
                <th width="*">类别</th>
                <th width="60">前台显示</th>
                <th width="80">图片</th>
                <th width="60" colspan="2">操作</th>
            </tr>
            <?php foreach($rows as $row){ ?>
            <tr align="center">
                <td><input name="id[<?php echo $row['id'];?>]" type="checkbox" value="<?php echo $row['id'];?>"></td>
                <td width="60"><input name="orderly[<?php echo $row['id'];?>]" type="text" data-type="float" value="<?php echo $row['orderly'] ?>"></td>
                <td align="left"><a title="编辑" href="<?php echo url('Image-edit', $row['id']); ?>"><?php echo $row['title']?></a></td>
                <td align="left"><?php echo $row['url']; ?></td>
                <td align="left"><?php echo isset($category[$row['cat']]) ? $category[$row['cat']] : ''; ?></td>
                <td><span class="right" data-href="<?php echo url('Image-ajax-show', $row['id']); ?>" data-val="<?php echo $row['is_show']; ?>"></span></td>
                <td><a href="<?php echo $row['img']; ?>" rel="fancybox" title="<?php echo $row['title'] ?>"><img class="thumbnail lazy" data-original="<?php echo $row['img']; ?>" src="<?php echo src('admin/image/null.gif'); ?>"></a></td>
                <td width="30"><a href="<?php echo url('Image-edit', $row['id']); ?>">编辑</a></td>
                <td width="30"><a class="del" href="<?php echo url('Image-del', $row['id']); ?>">删除</a></td>
            </tr>
            <?php } ?>
        </table>
    </form>
    <ul class="tool-bar">
        <li><button type="button" id="sort" class="btn">排序</button></li>
        <li><button type="button" id="del" class="btn">删除</button></li>
        <li><select id="move" name="move"><option value="">移动到...</option></select></li>
    </ul>
    <?php }else{ ?>
    <div class="empty">暂无内容</div>
    <?php } ?>
    <div class="paging"><?php echo $paging; ?></div>
</div>