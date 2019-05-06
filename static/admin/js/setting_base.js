"use strict";
$(function () {
    var form = document.forms[0],
        logo = document.getElementById('logo');

    new AjaxUpload('#upload', {
        action: Base.url(CONTROLLER, 'upload'),
        complete: function (response) {
            if (response.code) {
                showMessage(response.msg);
                form.elements['logo'].value = response.data;
                logo.src = response.data;
            } else {
                showError(response.msg);
            }
        }
    });
});