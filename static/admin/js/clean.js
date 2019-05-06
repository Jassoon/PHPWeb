"use strict";
//选择
$(function ($) {
    var items = $('.file-item');

    //全选
    $('#all').on('click', function () {
        items.addClass('selected');
    });

    //单选
    var item, index, selected, lastIndex = 0, lastSelected = false, range, rangeItems;
    items.on('click', function (e) {
        item = $(this);
        item.toggleClass('selected');
        index = item.index();
        selected = item.hasClass('selected');
        range = index - lastIndex;
        if (e.shiftKey && Math.abs(range) > 1 && lastSelected === selected) {
            rangeItems = (range > 0) ? items.slice(lastIndex + 1, index) : items.slice(index + 1, lastIndex);
            rangeItems.toggleClass('selected', selected);
        }
        lastIndex = index;
        lastSelected = selected;
    });
});

//删除
$(function ($) {
    var button = $('#remove'),
        url = Base.url(CONTROLLER, 'del');

    button.on('click', function () {
        var list = $('.file-item.selected').toArray();
        if (list.length === 0) {
            showError('请选择你要删除的数据');
            return;
        } else if (!confirm('文件删除后内容将无法恢复，\n你确定要删除选中的 ' + list.length + ' 个文件吗？')) {
            return;
        }
        button.prop('disabled', true).addClass('progress');

        (function removeFile() {
            if (list.length) {
                var item = list.shift();
                $.ajax(url, {
                    type: 'POST',
                    dataType: 'JSON',
                    data: {'file': item.getAttribute('data-file')}
                }).always(function () {
                    removeFile();
                }).done(function (re) {
                    re.code && item.remove();
                });
            } else {
                button.prop('disabled', false).removeClass('progress');
            }
        })();
    })
});