<div class="tab-bar">
    <ul class="tab">
        <?php if($this->auth(CONTROLLER, 'add')){ ?>
        <li class="tab-item"><a href="<?php echo url('Page-add'); ?>">添加页面</a></li>
        <?php } ?>
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">页面列表</a></li>
    </ul>
</div>
<div class="content">
    <?php if($rows){ ?>
    <form>
        <div class="panel">
            <label class="mr10">类别：
                <select name="cat" id="category">
                    <option value="">全部类别</option>
                    <?php
                    $cat = get('cat');
                    $category = C('PAGE_CATEGORY');
                    foreach($category as $key=>$val){
                        if($key === $cat){
                            echo "<option value='{$key}' selected='selected'>{$val}</option>";
                        }else{
                            echo "<option value='{$key}'>{$val}</option>";
                        }
                    }
                    ?>
                </select>
            </label>
            <label>标题：
                <input name="title" type="search" value="<?php echo get('title'); ?>" size="30" results="s" x-webkit-grammar="builtin:translate" x-webkit-speech>
            </label>
            <button type="submit" class="btn">开始搜索</button>
            <button type="button" class="btn" onClick="location.replace(location.pathname)">显示全部</button>
        </div>
    </form>
    <table class="list">
        <tr>
            <th width="30">ID</th>
            <th>标题</th>
            <th>类别</th>
            <th width="60" colspan="2">操作</th>
        </tr>
        <?php foreach($rows as $row){ ?>
        <tr>
            <td align="center"><?php echo $row['id'];?></td>
            <td><a title="编辑" href="<?php echo url('Page-edit', $row['id']); ?>"><?php echo $row['title'];?></a></td>
            <td><?php echo isset($category[$row['cat']]) ? $category[$row['cat']] : ''; ?></td>
            <td align="center" width="30"><a href="<?php echo url('Page-edit', $row['id']); ?>">编辑</a></td>
            <td align="center" width="30"><?php if($this->auth(CONTROLLER, 'del')){ ?><a class="del" href="<?php echo url('Page-del', $row['id']); ?>">删除</a><?php } ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php }else{ ?>
    <div class="empty">暂无内容</div>
    <?php } ?>
    <div class="paging"><?php echo $paging; ?></div>
</div>