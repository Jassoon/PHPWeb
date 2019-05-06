"use strict";
var Base = {
    //静态资源路径生成
    src: function (file) {
        return BASE_URL + 'static/' + file;
    },
    //URL地址生成
    url: function () {
        return BASE_URL + Array.prototype.join.call(arguments, '-');
    },
    //模板数据替换
    substitute: function (tpl, data) {
        return tpl.replace(/{([^{}]+)}/g, function (match, name) {
            var val = data[name];
            return (typeof val === 'string' || typeof val === 'number') ? val : match;
        })
    },
    getStyle: function (url) {
        $('head').append('<link rel="stylesheet" href="' + url + '">');
    },
    getScript: function (url) {
        return $.ajax({url: url, dataType: "script", cache: true});
    }
};

//图片预览
$.fn.imagePreview = function () {
    var popup = $('<div class="image-preview" style="display:none;"></div>').appendTo('body'),
        popupImg = $('<img/>').appendTo(popup),
        spacing = 10, //间距
        isShow = false, isReady = false, timerId = null;

    var win = $(window),
        winW = win.width();
    win.on('resize', function () {
        winW = win.width();
    });

    $(this).on('mouseenter', function () {
        clearTimeout(timerId);
        popupImg.attr('src', this.src);
        var self = $(this),
            height = self.height(),
            offSet = self.offset(),
            popupHeight = popup.outerHeight();
        popup.css({
            top: offSet.top - ((popupHeight - height) / 2),
            right: winW - offSet.left + spacing
        });
        if (!isShow) {
            popup.show();
            isShow = true;
        }
        if (!isReady) {
            popup.addClass('ready');
            isReady = true;
        }
    }).on('mouseleave', function () {
        timerId = setTimeout(function () {
            popup.hide();
            isShow = false;
        }, 300)
    });
};


//Common
$(function ($) {
    //Message
    var message = $('#message'),
        messageText = $('#messageText'),
        timeOut;
    window.showMessage = function (text, type) {
        clearTimeout(timeOut);
        messageText.text(text).attr('class', type || 'inform');
        message.addClass('down');
        timeOut = setTimeout(function () {
            message.removeClass('down');
        }, 6000);
    };
    window.showError = function (text) {
        showMessage(text, 'error');
    };
    var serverMessage = $.cookie('serverMessage');
    if (serverMessage) {
        showMessage(serverMessage);
        $.removeCookie('serverMessage', {path: BASE_URL});
    }

    //限制输入内容为浮点型
    $('input[data-type=float]').on('keyup', function () {
        this.value = this.value.replace(/[^\d.]/g, "");
        this.value = this.value.replace(/^\./g, "");
        this.value = this.value.replace(/\.{2,}/g, ".");
        this.value = this.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
    });

    var lazyImages = $('img.lazy');
    if (lazyImages.length) {
        Base.getScript(Base.src('common/jquery.lazyload.min.js')).done(function () {
            lazyImages.lazyload({
                'load': function () {
                    $(this).removeClass('lazy');
                }
            });
        });
    }

    var fancyBox = $('a[rel=fancybox]');
    if (fancyBox.length) {
        Base.getStyle(Base.src('common/fancybox/jquery.fancybox.min.css'));
        Base.getScript(Base.src('common/fancybox/jquery.fancybox.min.js')).done(function () {
            fancyBox.fancybox()
        });
    }

    $('.nav').each(function () {
        if (this.getElementsByTagName('li').length === 0) {
            this.style.display = 'none';
        }
    });
});

//Side Sticky
$(window).on('load', function () {
    var win = $(window),
        main = $('#main'),
        side = $('#side'),
        mainHeight = main.height(),
        sideHeight = side.height(),
        start = 36,
        end = start + (mainHeight - sideHeight);

    if (sideHeight > mainHeight) {
        return;
    }

    function setSidePosition() {
        var wst = win.scrollTop();
        if (wst > start) {
            side.addClass('fixed').css('top', Math.min(0, end - wst));
        } else {
            side.removeClass('fixed').css('top', '');
        }
    }

    win.on('scroll', setSidePosition);
    setSidePosition();
});

//List Page
$(function ($) {
    var listForm = $('#listForm');
    if (!listForm.length) {
        return;
    }

    var checkAll = $('#checkAll'),
        items = listForm.find('[name^=id]:checkbox'),//复选框
        lastItemIndex,
        lastItemChecked = false,
        rows = 0;

    //全选
    checkAll.on('change', function () {
        items.prop('checked', this.checked).parents('tr').toggleClass('checked', this.checked);
    });

    //单选
    items.on('click', function (e) {
        var index = items.index(this),
            checked = this.checked,
            range = index - lastItemIndex;

        $(this).parents('tr').toggleClass('checked', checked);

        /**
         * Shift 连续选择触发条件
         * 1.要按住Shift健; 2.两次操作元素之间的元素大于1; 3.两次操作的结果相同
         */
        if (e.shiftKey && Math.abs(range) > 1 && lastItemChecked === checked) {
            var rangeItems = (range > 0) ? items.slice(lastItemIndex + 1, index) : items.slice(index + 1, lastItemIndex);
            rangeItems.prop('checked', checked).parents('tr').toggleClass('checked', checked);
        }
        lastItemIndex = index;
        lastItemChecked = checked;

        //全选/取消 checkbox 状态
        rows = listForm.find('[name^=id]:checkbox:checked').length;
        if (!rows) {
            checkAll.prop('indeterminate', false).prop('checked', false);
        } else if (rows === items.length) {
            checkAll.prop('indeterminate', false).prop('checked', true);
        } else {
            checkAll.prop('indeterminate', true);
        }
    });

    //提交表单
    function submitForm(param) {
        var _url = Base.url(CONTROLLER, 'batch', param);
        $.post(_url, listForm.serialize(), function (response) {
            if (response.code) {
                $.cookie('serverMessage', response.msg, {path: BASE_URL});
                window.location.reload();
            } else {
                showError(response.msg);
            }
        }, 'json');
    }

    //排序
    $('#sort').on('click', function () {
        rows = listForm.find('[name^=id]:checkbox:checked').length;
        rows ? submitForm('sort') : showError('请选择你要排序的内容');
    });

    //删除
    $('#del').on('click', function () {
        rows = listForm.find('[name^=id]:checkbox:checked').length;
        if (!rows) {
            showError('请选择你要删除的内容');
            return false;
        } else if (!confirm('删除后内容将无法恢复，\n你确定要删除选中的 ' + rows + ' 条记录吗？')) {
            return false;
        }
        submitForm('del');
    });

    //移动到
    var move = $('#move');
    if (move.length) {
        move.html($('#category').html()).find('option:eq(0)').text('移动到...');
        move.on('change', function () {
            rows = listForm.find('[name^=id]:checkbox:checked').length;
            if (rows) {
                submitForm('move-' + move.val());
            } else {
                showError('请选择你要移动的内容');
                this.options[0].selected = true;
            }
        });
    }

    //(前台|首页)显示
    $('span[data-val]').click(function () {
        var val = (this.getAttribute('data-val') === '1') ? '0' : '1';
        this.setAttribute('data-val', val);
        $.get(this.getAttribute('data-href') + '?val=' + val);
    });

    //删除提示
    $('a.del').on('click', function (event) {
        event.preventDefault();
        if (confirm('删除后内容将无法恢复，你确定要删除吗？')) {
            $.getJSON(this.href, function (response) {
                if (response.code) {
                    $.cookie('serverMessage', response.msg, {path: BASE_URL});
                    window.location.reload();
                } else {
                    showError(response.msg);
                }
            })
        }
    });

    var thumbnail = $('.thumbnail');
    if (thumbnail.length) {
        thumbnail.imagePreview();
    }
});

//Item Page
$(function ($) {
    //上下文处理，上下文链接不产生历史记录
    $('a[data-target=replace]').on('click', function (event) {
        event.preventDefault();
        location.replace(this.href);
    });

    //显示更多内容控制开关
    $(':checkbox[data-details]').change(function () {
        $(this.getAttribute('data-details')).toggle(this.checked);
    });

    //Ajax表单提交
    $('#ajaxForm').on('submit', function (event) {
        event.preventDefault();
        $.post(this.action, $(this).serialize(), function (response) {
            response.code ? showMessage(response.msg) : showError(response.msg);
        });
    });

});

//加载编辑器
$(function () {
    if (typeof KindEditor !== 'function') {
        return;
    }

    var editors = $('textarea[data-editor]');
    if (!editors.length) {
        return;
    }

    var options = {
        uploadJson: Base.url('Editor-upload'),
        fileManagerJson: Base.url('Editor-manager'),
        allowFileManager: true,
        formatUploadUrl: false,
        urlType: "relative",
        imageTabIndex: 1,
        newlineTag: "br",
        filterMode: false,
        cssPath: Base.src('admin/style/editor.css'),
        afterBlur: function () {
            this.sync();
        }
    };

    var defaultItems = [],
        simpleItems = ['source', '|', 'undo', 'redo', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'lineheight', 'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', '|', 'image', 'link', 'unlink', 'clearhtml'];

    var ignore = {"code": 1, "emoticons": 1};
    $.each(KindEditor.options.items, function (index, item) {
        if (!ignore[item]) {
            defaultItems.push(item);
        }
    });

    editors.each(function (index, elem) {
        options.items = (elem.getAttribute('data-editor') === 'simple') ? simpleItems : defaultItems;
        KindEditor.create(elem, options);
    });
});