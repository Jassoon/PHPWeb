"use strict";
$(function ($) {
    //上传图片
    var form = document.forms[0],
        img1 = document.getElementById('img1'),
        img2 = document.getElementById('img2');

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
                if (this.filename && !form.elements['name'].value) {
                    form.elements['name'].value = this.filename;
                }
            } else {
                showError(response.msg);
            }
        }
    });

    //产品照片
    var tpl = '<li><img src="{img2}" /><span title="删除"></span><input type="hidden" name="album[{key}][img1]" value="{img1}"><input type="hidden" name="album[{key}][img2]" value="{img2}"></li>',
        album = $('#album'),
        length = album.children('li').length;

    //上传
    new AjaxUpload('#albumUpload', {
        action: Base.url(CONTROLLER, 'uploads'),
        multiple: true,
        complete: function (response) {
            var data = response.data,
                html = '';
            if (response.code) {
                showMessage(response.msg);
                $.each(data, function (i, val) {
                    val.key = length++;
                    html += Base.substitute(tpl, val);
                });
                album.append(html);
            } else {
                showError(response.msg);
            }
        }
    });

    //删除
    album.on('click', 'span', function () {
        $(this).closest('li').remove();
    });

    //排序
    album.dragsort();


    //表单验证
    form.onsubmit = function () {
        if ($.trim(this.elements['img1'].value) === '') {
            showError("您还没有上传图片，请先上传图片！");
            return false;
        }
        if ($.trim(this.elements['name'].value) === '') {
            showError("请填写产品名称");
            this.elements['name'].focus();
            return false;
        }
        return true;
    };
});