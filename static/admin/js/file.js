"use strict";
$(function ($) {
    var form = document.forms[0];

    //上传文件
    new AjaxUpload($('#upload'), {
        action: Base.url(CONTROLLER, 'upload'),
        accept: '',
        fileType: ['rar', 'zip', '7z', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'],
        complete: function (response) {
            if (response.code) {
                showMessage(response.msg);
                form.elements['file'].value = response.data;
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
        if ($.trim(this.elements['file'].value) === '') {
            showError('你还没有上传文件，请先上传文件');
            return false;
        }
        if ($.trim(this.elements['title'].value) === '') {
            showError('文件名称不能为空');
            this.elements['title'].focus();
            return false;
        }
        return true;
    };

});