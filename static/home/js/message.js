"use strict";
$(function ($) {
    var messageForm = $('#messageForm'),
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
            $.post(form.action, $(form).serialize(), function (response) {
                if (response.code) {
                    form.reset();
                }
                button.prop('disabled', false);
                preloader.hide();
                alert(response.msg);
            }, 'json');
        }
    });
});