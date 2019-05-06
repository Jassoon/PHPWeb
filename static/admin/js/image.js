"use strict";
$(function ($) {
    var form = document.forms[0],
        img = document.getElementById('img');

    //上传图片
    new AjaxUpload('#upload', {
        action: Base.url(CONTROLLER, 'upload'),
        complete: function (response) {
            if (response.code) {
                showMessage(response.msg);
                form.elements['img'].value = response.data;
                img.src = response.data;
                if (this.filename && !form.elements['title'].value) {
                    form.elements['title'].value = this.filename;
                }
            } else {
                showError(response.msg);
            }
        }
    });

    //表单验证
    form.onsubmit = function () {
        if ($.trim(this.elements['img'].value) === '') {
            showError('您还没有上传图片！');
            return false;
        }
        return true;
    };

});