"use strict";
$(function ($) {
    // 单行全选操作
    $('li.item').each(function (i, v) {
        var item = $(v),
            box = item.find(':checkbox');
        item.find('span').on('click', function () {
            var val = box.filter(':checked').length < box.length;
            box.prop('checked', val);
        });
    });

    // 整体全选操作
    var checkbox = $(':checkbox');

    //全选
    $('#checkAll').on('click', function () {
        checkbox.prop('checked', true);
    });

    //反选
    $('#inverse').on('click', function () {
        checkbox.prop('checked', function () {
            return !this.checked;
        });
    });

    //取消
    $('#deselect').on('click', function () {
        checkbox.prop('checked', false);
    });

    //添加表单模式验证方法
    $.validator.addMethod("pattern", function (value, element, param) {
        if (this.optional(element)) {
            return true;
        }
        if (typeof param === "string") {
            param = new RegExp("^(?:" + param + ")$");
        }
        return param.test(value);
    }, "无效格式");

    $('#userForm').validate({
        rules: {
            name: {required: true},
            account: {
                minlength: 4,
                pattern: "^[A-Za-z0-9.]{4,16}$",
                remote: REMOTE_URL
            },
            password: {
                minlength: 4,
                pattern: "^[A-Za-z0-9.]{4,16}$"
            }
        },
        messages: {
            account: {
                minlength: "长度不能少于4个字符",
                pattern: "格式错误，帐号只能为数字和字母",
                remote: "此帐号已使用"
            },
            password: {
                minlength: "长度不能少于4个字符",
                pattern: "格式错误，密码只能为数字和字母"
            }
        },
        submitHandler: function (form) {
            $.post(form.action, $(form).serialize(), function (response) {
                if (response.code) {
                    $.cookie('serverMessage', response.msg, {path: BASE_URL});
                    location.href = Base.url(CONTROLLER);
                } else {
                    showError(response.msg);
                }
            });
        }
    });
});