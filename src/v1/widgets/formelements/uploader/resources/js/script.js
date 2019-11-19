var componentCdnUploader = {
    initialization : function () {
        $('.cdnuploader').off();
        $('.cdnuploader').fileupload({
            add : function (e, data) {
                var $self = $(this);
                var pluginOptions = $(this).attr('plugin-options');
                if(pluginOptions !== undefined) {
                    var options = JSON.parse(pluginOptions);
                    if( typeof options == "object") {
                        $.each(options, function(key, value){
                            $self.fileupload('option', key, value);
                        });
                    }
                }

                $self.parent().addClass('disabled');
                $self.attr('disabled', 'disabled');
                var wrapper = $self.closest('.cdn-upload-wrapper');
                var infoContainer = wrapper.find('.file-info');
                infoContainer.addClass('d-none');
                var formData = $.parseJSON($(this).attr('data-options'));
                legalCdnUtility.auth(
                    formData,
                    function(response)
                    {
                        if(response.status !== 'success') {
                            componentNotify.fire(componentNotify.statuses.error, response.message);

                            return;
                        }
                        data.url = response.uploadUrl;
                        data.headers = {
                            'Authorization': 'Bearer ' + response.token
                        };
                        data.formData = formData;
                        data.submit();
                    }
                );
            },
            done : function(e, data) {
                if(data.result.failure) {
                    componentNotify.fire(componentNotify.statuses.error, data.result.failure);

                    return;
                }

                var $self = $(this);
                if(data.result.success && data.result.success.length > 0) {
                    var files = legalCdnUtility.parseResponse(data.result.success);
                    var file = files[0];
                    var info = file;
                    if(file.thumbs !== undefined && file.thumbs.thumb !== undefined) {
                        info = file.thumbs.thumb;
                    }

                    var $wrapper = $self.closest('.cdn-upload-wrapper');
                    var $infoContainer = $wrapper.find('.file-info');
                    var $displayContainer = $wrapper.find('.file-display');
                    var $nameContainer = $wrapper.find('.file-name');
                    var $sizeContainer = $wrapper.find('.file-size');
                    var $deleteControll = $wrapper.find('.file-delete');

                    var image = $('<img\/>', {
                        src: info.url,
                        'class': 'card-img img-fluid'
                    });

                    delete (info.url);
                    $deleteControll.attr('data-file-id', info.id);
                    $displayContainer.html(image);
                    $nameContainer.html(info.path);
                    $sizeContainer.html(info.size);
                    $infoContainer.removeClass('d-none');

                    var result = JSON.stringify(info);
                    $wrapper.find('input[type=\'hidden\']').val(result);
                }
            },
            fail : function(e, data) {
                var messaga = data.jqXHR.status + ' : ' + data.jqXHR.statusText;

                componentNotify.fire(componentNotify.statuses.error, messaga);
            },
            progressall : function(e, data) {
                var $self = $(this);
                var wrapper = $self.closest('.cdn-upload-wrapper');
                var progress = parseInt(data.loaded / data.total * 100, 10);
                var progressBox = wrapper.find('.progress');
                progressBox.removeClass('d-none');
                var progressBar = progressBox.find('.progress-bar');
                progressBar.css({'width': progress + '%'});
                progressBar.find('span').html(progress + '%');
            },
            always : function(e, data) {
                var $self = $(this);
                var wrapper = $self.closest('.cdn-upload-wrapper');
                var progressBox = wrapper.find('.progress');
                progressBox.addClass('d-none');
                var progressBar = progressBox.find('.progress-bar');
                var percent = 0 + '%';
                progressBar.css({'width': percent});
                progressBar.find('span').html(percent);
                $self.parent().removeClass('disabled');
                $self.removeAttr('disabled');
            }
        });

        // удаление изображения
        $('.cdn-upload-wrapper .file-delete').off('click');
        $('.cdn-upload-wrapper .file-delete').on('click', function(e) {
            e.preventDefault();
            var file_id = $(this).attr('data-file-id');
            if(file_id === undefined) {
                return false;
            }

            var $wrapper = $(this).closest('.cdn-upload-wrapper');
            var $uploader = $wrapper.find('.cdnuploader');
            var formData = $.parseJSON($uploader.attr('data-options'));
            legalCdnUtility.auth(
                formData,
                function (response) {
                    if (response.status !== 'success') {
                        componentNotify.fire(componentNotify.statuses.error, response.message);

                        return;
                    }

                    $.ajax({
                        url: response.deleteUrl + '/'  + file_id,
                        type: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + response.token
                        },
                        success: function () {
                            var $infoContainer = $wrapper.find('.file-info');
                            var $displayContainer = $wrapper.find('.file-display');
                            var $nameContainer = $wrapper.find('.file-name');
                            var $sizeContainer = $wrapper.find('.file-size');
                            var $deleteControll = $wrapper.find('.file-delete');

                            $infoContainer.addClass('d-none');
                            $displayContainer.html('');
                            $deleteControll.removeAttr('data-file-id');
                            $nameContainer.html('');
                            $sizeContainer.html('');
                            $wrapper.find('input[type=\'hidden\']').val('');
                        }
                    });
                }
            );

        })
    }
}
$(document).ready(function () {
    componentCdnUploader.initialization();
});