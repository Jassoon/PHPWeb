"use strict";
$.fn.placeholder = function () {
    return this.each(function (index) {
        var input = $(this);

        var inputParent = input.parent();
        if (inputParent.css('position') === 'static') {
            inputParent.css('position', 'relative');
        }

        var inputId = input.attr('id');
        if (!inputId) {
            inputId = 'placeholder' + index;
            input.attr('id', inputId);
        }

        var label = $('<label class="placeholder"></label>');
        label.attr('for', inputId);
        label.text(input.attr('placeholder'));

        var labelClass = input.data('class');
        if (labelClass) {
            label.addClass(labelClass);
        }

        var position = input.position();
        label.css({
            'position': 'absolute',
            'top': position.top,
            'left': position.left,
            'cursor': 'text'
        });

        if (this.value.length) {
            label.hide();
        }

        input.after(label);

        input.on('focus', function () {
            label.hide();
        }).on('blur', function () {
            if (this.value === '') {
                label.show();
            }
        });

        this.attachEvent('onpropertychange', function () {
            input.val() ? label.hide() : label.show();
        });
    })
};

$(function ($) {

    //表单占位符
    if (!("placeholder" in document.createElement("input"))) {
        $(':input[placeholder]').placeholder();
    }

    //重载验证码
    var captchaImage = $('#captchaImage');
    captchaImage.on('click', function () {
        this.src = 'captcha?_=' + (new Date()).getTime();
    });

    //表单提交
    var myForm = $('#login'),
        button = $('#submit').prop('disabled', false);

    myForm.on('submit', function (event) {
        event.preventDefault();

        var account = this.account;
        if (account.value === '') {
            alert('请输入帐号');
            account.focus();
            return false;
        }

        var accountReg = new RegExp(account.getAttribute('pattern'));
        if (!accountReg.test(account.value)) {
            alert('帐号格式错误');
            account.focus();
            return false;
        }

        var password = this.password;
        if (password.value === '') {
            alert('请输入密码');
            password.focus();
            return false;
        }

        var passwordReg = new RegExp(password.getAttribute('pattern'));
        if (!passwordReg.test(password.value)) {
            alert('密码格式错误');
            password.focus();
            return false;
        }

        var captcha = this.captcha;
        if (captcha.value === '') {
            alert('请输入验证码');
            captcha.focus();
            return false;
        }

        var captchaReg = new RegExp(captcha.getAttribute('pattern'));
        if (!captchaReg.test(captcha.value)) {
            alert('验证码格式错误');
            captcha.focus();
            return false;
        }

        button.prop('disabled', true).addClass('progress');
        $.ajax({
            url: this.action,
            type: 'POST',
            dataType: 'json',
            timeout: 800,
            data: {
                "account": account.value,
                "password": CryptoJS.MD5(password.value).toString(),
                "captcha": captcha.value
            }
        }).done(function (response) {
            if (response.code) {
                window.location.replace(BACK_URL);
            } else {
                alert(response.msg);
                captchaImage.trigger('click');
            }
        }).always(function () {
            button.prop('disabled', false).removeClass('progress');
        });
    });

});