"use strict";
$(function ($) {
    $('#form').on('submit', function (event) {
        event.preventDefault();

        var oldPassword = this.elements['old'];
        if (!oldPassword.value) {
            showError("请输入原密码");
            oldPassword.focus();
            return false;
        }

        var oldPasswordReg = new RegExp(oldPassword.getAttribute('pattern'));
        if (!oldPasswordReg.test(oldPassword.value)) {
            showError('原密码格式错误');
            oldPassword.focus();
            return false;
        }

        var newPassword = this.elements['password'];
        if (!newPassword.value) {
            showError("请输入新密码");
            newPassword.focus();
            return false;
        }

        var newPasswordReg = new RegExp(newPassword.getAttribute('pattern'));
        if (!newPasswordReg.test(newPassword.value)) {
            showError('新密码格式错误');
            newPassword.focus();
            return false;
        }

        var data = {
            "old": oldPassword.value,
            "password": newPassword.value
        };

        $.post(this.action, data, function (response) {
            if (response.code) {
                alert(response.msg);
                window.location.replace(LOGIN_URL);
            } else {
                showError(response.msg);
            }
        }, 'json')
    });
});