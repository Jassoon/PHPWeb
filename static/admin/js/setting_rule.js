"use strict";
$(function ($) {
    var form = document.forms[0],
        watermarkShow = document.getElementById('watermarkShow');

    //上传图片
    new AjaxUpload('#upload', {
        action: Base.url(CONTROLLER, 'upload'),
        complete: function (response) {
            if (response.code) {
                showMessage(response.msg);
                form.elements['watermark_img'].value = response.data;
                watermarkShow.src = response.data;
            } else {
                showError(response.msg);
            }
        }
    });

    //水印开关
    var watermark = $('#watermarkSettings');
    $(':radio[name=watermark]').on('change', function () {
        (this.value === '1') ? watermark.show() : watermark.hide();
    });

});