"use strict";
$(function ($) {

    //Create
    var backup = $('#backup');
    backup.on('click', function () {
        var $this = $(this);
        $this.addClass('progress');
        this.disabled = true;
        $.getJSON(this.getAttribute('data-href'), function (response) {
            if (response.code) {
                $.cookie('serverMessage', response.msg, {path: BASE_URL});
                window.location.reload();
            } else {
                showError(response.msg);
            }
            $this.removeClass('progress');
        })
    });

    //Delete
    $('a.del').on('click', function (e) {
        e.preventDefault();
        if (confirm('删除后内容将无法恢复，你确定要删除吗？')) {
            var self = $(this);
            $.getJSON(this.href, function (response) {
                if (response.code) {
                    self.parents('tr').remove();
                    showMessage(response.msg);
                } else {
                    showError(response.msg);
                }
            })
        }
    })

});