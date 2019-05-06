"use strict";
//Gallery
$(function ($) {
    var gallery = $('#gallery'),
        container = gallery.find('.gallery-container'),
        containerWidth = container.innerWidth(),
        list = container.find('.gallery-list'),
        items = list.find('.gallery-item'),
        itemWidth = items.outerWidth(true),
        listWidth = itemWidth * items.length;

    if (listWidth <= containerWidth) {
        return;
    }

    var prev = gallery.find('.gallery-prev'),
        next = gallery.find('.gallery-next'),
        prevState = true,
        nextState = true,
        number = 2, //一次滚动几张图片
        distance = number * itemWidth,
        duration = 300, //动画时长
        easing = 'swing', //动画效果 linear || swing
        left = 0;

    list.width(listWidth);

    function init() {
        if (left === 0) {
            prevState = false;
            prev.addClass('disabled');
        } else {
            prevState = true;
            prev.removeClass('disabled');
        }

        if (left >= listWidth - containerWidth) {
            nextState = false;
            next.addClass('disabled');
        } else {
            nextState = true;
            next.removeClass('disabled');
        }
    }

    init();

    prev.on('click', function () {
        if (prevState === false) {
            return;
        }
        left = Math.max(0, left - distance);
        container.stop(true, true).animate({'scrollLeft': left}, duration, easing);
        init();
    });

    next.on('click', function () {
        if (nextState === false) {
            return;
        }
        left = Math.min(listWidth - containerWidth, left + distance);
        container.stop(true, true).animate({'scrollLeft': left}, duration, easing);
        init();
    })
});

//询价
$(function ($) {
    var dialog = $('#dialog'),
        dialogMask = $('#dialogMask');

    $('#dialogClose').on('click', function () {
        dialog.hide();
        dialogMask.hide();
    });

    $('#inquiryBtn').on('click', function () {
        dialog.show();
        dialogMask.show();
    });

    var messageForm = $('#messageForm'),
        textarea = $('#textarea'),
        button = $('#button'),
        preloader = $('#preloader');

    button.prop('disabled', false); //启用提交按钮

    //表单验证
    messageForm.validate({
        rules: {
            phone: {
                required: true,
                number: true
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            phone: {
                required: "请输入电话号码",
                number: "电话号码格式错误"
            },
            email: {
                required: "请输入邮箱地址",
                email: "邮箱地址格式错误"
            }
        },
        submitHandler: function (form) {
            button.prop('disabled', true);
            preloader.show();
            textarea.val(textarea.val() + "\n------------------------------\n询价产品：" + location.href);
            $.post(form.action, $(form).serialize(), function (response) {
                button.prop('disabled', false);
                preloader.hide();
                alert(response.msg);
                if (response.code) {
                    form.reset();
                    dialog.hide();
                    dialogMask.hide();
                }
            }, 'json');
        }
    });
});