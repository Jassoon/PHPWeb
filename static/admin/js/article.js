"use strict";
$(function ($) {
    document.forms[0].onsubmit = function () {
        if ($.trim(this.elements['title'].value) === '') {
            showError('请输入标题');
            this.elements['title'].focus();
            return false;
        }
        return true;
    };
});