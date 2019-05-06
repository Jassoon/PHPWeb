"use strict";
$(function ($) {
    document.forms[0].onsubmit = function () {
        if ($.trim(this.elements['account'].value) === '') {
            showError('请输入客服号码');
            this.elements['account'].focus();
            return false;
        }
        if ($.trim(this.elements['name'].value) === '') {
            showError('请输入客服名称');
            this.elements['name'].focus();
            return false;
        }
        return true;
    };
});