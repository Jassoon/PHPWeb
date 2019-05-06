<div class="tab-bar">
    <ul class="tab">
        <li class="tab-item current"><a href="<?php echo SELF_URL; ?>">留言列表</a></li>
    </ul>
</div>
<div class="content">
    <form>
        <div class="panel">
            <label class="mr10">类型：
                <select name="type" id="category">
                    <option value="">全部类型</option>
                    <?php
                    $type = get('type');
                    $types = C('MESSAGE_TYPE');
                    foreach($types as $key => $val){
                        if($key == $type){
                            echo "<option value='{$key}' selected='selected'>{$val}</option>";
                        }else{
                            echo "<option value='{$key}'>{$val}</option>";
                        }
                    }
                    ?>
                </select>
            </label>
            <label>关健词：
                <input name="key" type="search" value="<?php echo get('key'); ?>" size="30" results="s" x-webkit-grammar="builtin:translate" x-webkit-speech>
            </label>
            <button type="submit" class="btn">开始搜索</button>
            <button type="button" class="btn" onClick="location.replace(location.pathname)">显示全部</button>
        </div>
    </form>
    <?php if($rows){ ?>
        <form method="post" id="listForm">
        <table class="list">
            <tr>
                <th width="30"><input id="checkAll" type="checkbox"></th>
                <th width="*">主题</th>
                <th>类型</th>
                <th width="150">时间</th>
                <th width="60" colspan="2">操作</th>
            </tr>
            <?php foreach($rows as $row){ ?>
            <tr class="<?php if($row['is_read']==='0'){ echo 'blue'; } ?>">
                <td align="center"><input name="id[]" type="checkbox" value="<?php echo $row['id'];?>"></td>
                <td><a href="<?php echo url('Message-item', $row['id']); ?>" title="查看" ><?php echo $row['subject']; ?></a></td>
                <td><?php echo isset($types[$row['type']]) ? $types[$row['type']] : ''; ?></td>
                <td align="center"><?php echo date('Y-m-d H:i:s', $row['create_time']); ?></td>
                <td align="center" width="30"><a href="<?php echo url('Message-item', $row['id']); ?>">查看</a></td>
                <td align="center" width="30"><a class="del" href="<?php echo url('Message-del', $row['id']); ?>">删除</a></td>
            </tr>
            <?php } ?>
        </table>
    </form>
    <ul class="tool-bar">
        <li><button type="button" id="del" class="btn">删除</button></li>
    </ul>
    <?php }else{ ?>
    <div class="empty">暂无内容</div>
    <?php } ?>
    <div class="paging"><?php echo $paging; ?></div>
</div>