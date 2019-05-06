"use strict";
$(function ($) {
    document.forms[0].onsubmit = function () {
        if ($.trim(this.elements['name'].value) === '') {
            showError('请输入链接名称');
            this.elements['name'].focus();
            return false;
        }
        if ($.trim(this.elements['url'].value) === '') {
            showError('请输入链接地址');
            this.elements['url'].focus();
            return false;
        }
        return true;
    };
});