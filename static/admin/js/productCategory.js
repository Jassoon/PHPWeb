"use strict";
$(function () {
    document.forms[0].onsubmit = function () {
        if ($.trim(this.elements['cat_name'].value) === '') {
            showError('请输入类别名称');
            this.elements['cat_name'].focus();
            return false;
        }
        return true;
    };
});