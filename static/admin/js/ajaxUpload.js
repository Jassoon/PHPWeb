/*! jQuery Plugin AjaxUpload 20170704 */
(function ($) {
    "use strict";
    var body = $(document.body),
        index = 0;

    //获取文件扩展名
    function getExt(file) {
        return file.split('.').pop().toLowerCase();
    }

    //获取文件名(不含扩展名)
    function getFilename(file) {
        var index = file.lastIndexOf('.');
        return file.substr(0, index);
    }

    //Ajax Upload
    var AjaxUpload = function (button, options) {
        this.button = $(button);
        this.settings = $.extend({}, AjaxUpload.default, options || {});
        this.filename = '';
        this.init();
    };

    AjaxUpload.default = {
        "name": 'file',
        "multiple": false,
        "action": 'upload.php',
        "accept": 'image/*',
        "fileType": ['jpg', 'gif', 'png'], //允许上传的文件扩展名
        "complete": $.noop,
        "showMessage": function (message) {
            (typeof window.showMessage === 'function') ? showMessage(message, 'error') : alert(message);
        }
    };

    AjaxUpload.prototype = {
        init: function () {
            this.id = new Date().getTime() + '_' + (index++); //唯一id
            var self = this,
                button = this.button;

            var input = $('<input type="file" id="ajaxUploadInput_' + this.id + '">');
            if (this.settings.multiple) {
                input.attr('name', this.settings.name + '[]');
                input.prop('multiple', true);
            } else {
                input.attr('name', this.settings.name);
            }
            if (this.settings.accept) {
                input.attr('accept', this.settings.accept);
            }

            var label = $('<label class="ajax-upload" for="ajaxUploadInput_' + this.id + '">' + button.text() + '</label>'),
                form = $('<form class="ajax-upload" method="post" enctype="multipart/form-data"></form>');
            form.append(input).append(label);
            body.append(form);

            form.on('mouseleave', function () {
                this.style.display = "none";
            });
            button.on('mouseenter', function () {
                if (button.hasClass('progress')) {
                    return;
                }
                var offset = button.offset();
                form.css({
                    "width": button.outerWidth(),
                    "height": button.outerHeight(),
                    "top": offset.top,
                    "left": offset.left,
                    "display": "block"
                })
            });

            input.on('change', function () {
                var file = $.trim(this.value);
                if ($.inArray(getExt(file), self.settings.fileType) === -1) {
                    self.settings.showMessage('文件格式错误,允许上传的文件格式为' + self.settings.fileType.join(','));
                    return;
                }
                button.addClass('progress');
                if (window.FormData) {
                    self.filename = getFilename(this.files[0].name);
                    self.requestUpload(input, form);
                } else {
                    self.emulateUpload(input, form);
                }
            });
        },

        //ajax请求上传
        requestUpload: function (input, form) {
            var self = this;
            $.ajax(this.settings.action, {
                type: "POST",
                data: new FormData(form[0]),
                cache: false,
                dataType: "json",
                contentType: false,
                processData: false
            }).always(function () {
                input.val('');
                self.button.removeClass('progress');
            }).done(function (response) {
                self.settings.complete.call(self, response);
            }).fail(function () {
                self.settings.showMessage('请求异常');
            });
        },

        //模拟上传
        emulateUpload: function (input, form) {
            var self = this,
                iframeId = 'ajaxUploadIframe_' + this.id;

            form.attr({"action": this.settings.action, "target": iframeId});
            var iframe = $('<iframe id="' + iframeId + '" class="ajax-upload" src="javascript:false;" name="' + iframeId + '"></iframe>');
            iframe.on('load', function () {
                var response = $(this).contents().text();
                if (response) {
                    try {
                        response = eval("(" + response + ")");
                        self.settings.complete.call(self, response);
                    } catch (e) {
                        self.settings.showMessage('上传异常');
                    }
                } else {
                    self.settings.showMessage('请求异常');
                }
                self.button.removeClass('progress');
                iframe.remove(); //上传完成后移除iframe
                self.init(); //上传完成后创建一个新的input
            });
            body.append(iframe);
            form.trigger('submit');
        }
    };

    window.AjaxUpload = AjaxUpload;
})(jQuery);