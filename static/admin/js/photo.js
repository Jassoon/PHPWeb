"use strict";
$(function ($) {
    var form = document.forms[0],
        img1 = document.getElementById('img1'),
        img2 = document.getElementById('img2');

    //上传图片
    new AjaxUpload('#upload', {
        action: Base.url(CONTROLLER, 'upload'),
        complete: function (response) {
            var data = response.data;
            if (response.code) {
                showMessage(response.msg);
                form.elements['img1'].value = data.img1;
                form.elements['img2'].value = data.img2;
                img1.href = data.img1;
                img2.src = data.img2;
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
        if ($.trim(this.elements['img1'].value) === '') {
            showError('您还没有上传图片，请先上传图片！');
            return false;
        }
        if ($.trim(this.elements['title'].value) === '') {
            showError('请填写图片标题');
            this.elements['title'].focus();
            return false;
        }
        return true;
    };

});