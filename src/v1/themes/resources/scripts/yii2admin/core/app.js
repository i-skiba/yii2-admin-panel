var Yii2Admin = {
    translations : {},
    t : function (key) {
        if(typeof this.translations[key] === 'undefined') {
            return null;
        }

        return  this.translations[key];
    },
    sendRequest : function (action , pjax_id , pjax_url , params, callback) {
        var self = this;
        $.ajax({
            type : 'POST',
            url : action,
            data : params,
            success : function(data) {
                try {
                    var response = $.parseJSON(data);
                } catch(e) {
                    var response = data;
                }

                if(typeof pjax_id === 'undefined') {
                    componentNotify.pNotify(response.type, response.message);
                } else {
                    var pjaxOptions = {
                        push : false,
                        replace : false
                    };
                    if(typeof pjax_url !== 'undefined') {
                        pjaxOptions['url'] = pjax_url;
                    }

                    $.pjax.reload('#' + pjax_id , pjaxOptions);
                    self.notify(response);
                }

                if(typeof callback !== 'undefined') {
                    self.runCallback(callback, response)
                }

                if(typeof response.redirectUrl !== 'undefined') {
                    location.href = response.redirectUrl;
                }

            }, error : function(data) {
                var messaga = data.status + ' : ' + data.statusText;
                componentNotify.pNotify(componentNotify.statuses.error, messaga);
            }
        });
    },
    notify : function(response) {
        if(typeof response.flash !== 'undefined') {
            FlashAlertHelper.interval = FlashAlertHelper.show(response);
        }

        if(
            typeof response.type !== 'undefined'
            && typeof response.message !== 'undefined'
        ) {
            componentNotify.pNotify(response.type, response.message);
        }
    },
    // рецепт, понаблюдать
    runCallback : function(callback, data) {
        if(typeof callback === 'function') {
            return eval(callback)(data);
        }

        var wrap = s => "{ return " + callback.trim() + " };"
        var func = new Function( wrap(callback) );
        try{
            func.call(null).call(null, data);
        } catch(e) {}
    }
};

var CallbackHelper = {
    reloadList: function(id) {
        $.pjax.reload('#' + id);
    }
};

var FlashAlertHelper = {
    interval : null,
    $container : null,
    duration : 7000,
    show : function( response ) {
        this.$container.html('');
        if(typeof response.flash !== 'undefined') {
            data = response.flash;
        } else {
            data = response;
        }

        if(! data) {
            return false;
        }

        this.$container.html(data);

        return this.hide();
    },
    hide : function() {
        var self = this;
        self.reset();

        return setTimeout(
            function() {
                self.$container.html('');
            } ,
            self.duration
        );
    },
    reset : function() {
        clearTimeout(this.interval);
    },
    initialization : function () {
        this.$container = $('.admin-flash');
        this.interval = this.hide();
    }
};

var UrlHelper = {
    addParam : function(queryString, param, value) {
        queryParameters = this._getQueryParameters(queryString);
        queryParameters[param] = value;

        return $.param(queryParameters);
    },
    removeParam : function(queryString, param) {
        queryParameters = this._getQueryParameters(queryString);
        delete queryParameters[param];

        return $.param(queryParameters);
    },
    _getQueryParameters : function(queryString) {
        var queryParameters = {}, re = /([^&=]+)=([^&]*)/g, m;
        while (m = re.exec(queryString)) {
            queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
        }

        return queryParameters;
    }
}

var MagicModal = {
    $modal: null,
    $container: null,
    modalSizes : [
        'modal-full',
        'modal-lg',
        'modal-sm',
        'modal-xs'
    ],
    response: null,
    isJsonResponse: false,
    callback: null,
    pjax: {
        selector: '#magic-modal-pjax',
        settings : {
            push : false,
            scrollTo : false,
            replace : false
        },
        reload: function() {
            $.pjax.reload(this.selector, this.settings);
        },
        submit: function(event) {
            $.pjax.submit(event, this.selector, this.settings);
        },
    },
    applySize: function(size_class) {
        if(
            typeof size_class == 'undefined'
            || this.$container.hasClass(size_class)
        ) {
            return false;
        }

        this.$container.removeClass(this.modalSizes.join(' '));
        this.$container.addClass(size_class);
    },
    setCallback: function(callback) {
        if(typeof callback == 'undefined') {
            return false;
        }

        this.callback = callback
    },
    reset: function() {
        this.response = null;
        this.isJsonResponse = false;
        this.callback = null;
    },
    initialization : function () {
        this.reset();
        this.$modal = $('#magic-modal');
        if(this.$modal.length > 0) {
            this.$container = this.$modal.find('.modal-dialog');
        }
    }
}

$(document).ready(function() {
    // инициализация плагинов
    FlashAlertHelper.initialization();
    MagicModal.initialization();
    componentChekboxes.uniform();
    componentChekboxes.switchery();
    componentChekboxes.bootstrap();
    componentSelects.uniform();
    $('.history-back').click(function() {
        window.history.back();
    });
    // preloader при ajax запросах
    $(document)
        .ajaxStart(function() {
            $.blockUI({
                message: '<i class="icon-spinner4 spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    // color: '#fff',
                    padding: 0,
                    zIndex: 1201,
                    backgroundColor: 'transparent'
                }
            });
        }).ajaxStop(function(){
            $.unblockUI();
        });

    var $listPjax = $('#list-pjax');
    // убиваем таймаут
    $listPjax.on('pjax:timeout', function (event, data) {
        event.preventDefault()
    });
    // по завершению обновления листа реинициализируем плагины
    $listPjax.on('pjax:end', function(object, xhr) {
        if(xhr.status != 200) {
            return;
        }

        componentChekboxes.bootstrap();
        componentChekboxes.uniform();
        componentSelects.uniform();
        if(typeof componentCdnUploader !== 'undefined') {
            componentCdnUploader.initialization();
        }

        App.initCardActions();
    });

    $listPjax.on('pjax:error', function(xhr, response) {
        var message = response.status + ' : ' + response.statusText;
        componentNotify.pNotify(componentNotify.statuses.error, message);

        return false;
    });

    // Поиск по grid-view / list-view
    $(document).on('submit', '.search-box form', function(event) {
        $.pjax.submit(event, '#list-pjax');
    });
    // Очистка полей поиска
    $(document).on('click','.search-clear' ,function(e){
        e.preventDefault();
        var form = $(this).closest('.search-box form');
        form.find('input[type="text"]').val('');
        //.row чтобы не сбрасывались системные hidden поля, а только поля формы поиска
        form.find('.row input[type="hidden"]').val('');
        form.find('select').val('');
        if($('.selectbox').length > 0) {
            $('.selectbox').data("selectBox-selectBoxIt").refresh();
        }

        form.find('input[type="checkbox"]').removeAttr('checked');
        // removeBootstrapClass();
        form.submit();
    });
    // действия в админке
    $(document).on('click','.admin-action',function(e){
        e.preventDefault();
        FlashAlertHelper.reset();
        var action = $(this).attr('href');
        var data = $(this).data();
        if(typeof data.params !== 'undefined') {
            data.params = JSON.parse(data.params);
        }

        if(typeof action === 'undefined') {
            return false;
        }

        if(typeof data.swal === 'undefined') {
            Yii2Admin.sendRequest(action, data.pjaxId, data.pjaxUrl, data.params, data.callback)
        }

        componentNotify.sweetAlert(data.swal, function () {
            Yii2Admin.sendRequest(action, data.pjaxId, data.pjaxUrl, data.params, data.callback)
        });
    });

    var $magicModalPjax = $(MagicModal.pjax.selector);
    $(document).on('click', '.magic-modal-control', function(e){
        e.preventDefault();
        var data = $(this).data();
        // // callback = $(this).attr('data-callback');
        MagicModal.applySize( data.modalSize );
        MagicModal.setCallback( data.callback );
        MagicModal.pjax.settings.url = data.url;
        //если элемент находится в форме
        var $serializeElement = $(this).closest('form');
        if($serializeElement.length === 0) {
            var selector = data.serializeSelector;
            if(typeof selector !== 'undefined') {
                //TODO реализовать пригодится
                //parts = selector.split('||');
                $serializeElement = $(selector);
            }
        }

        var formData = null;
        //TODO сбор данных с более одного селектора
        if($serializeElement.length === 1) {
            formData = serializeControl.serialize();
            //удаление параметра _csrf из серилизованной строки
            formData = formData.replace( /_csrf=(.*?)\&/g, "" );
            MagicModal.pjax.settings.data = formData;
            delete MagicModal.pjax.settings.data['_scrf'];
        }
        MagicModal.pjax.reload();
    });

    $(document).on('submit', MagicModal.pjax.selector + ' form', function(event) {
        var $form = $(this);
        MagicModal.pjax.settings.url = $form.attr('action');
        delete MagicModal.pjax.settings.data;
        MagicModal.pjax.submit(event);

    });

    $magicModalPjax.on('pjax:timeout', function (event, data) {
        event.preventDefault();
    });

    $magicModalPjax.on('pjax:beforeSend', function (event, data) {
        MagicModal.reset();
    });

    $magicModalPjax.on('pjax:success', function(data, status, xhr, options) {
        try {
            var response = $.parseJSON(status);
            MagicModal.isJsonResponse = true;
            Yii2Admin.notify(response);
            if(typeof MagicModal.callback !== 'undefined') {
                Yii2Admin.runCallback(callback, response.data);
                MagicModal.callback = null;
            }
        } catch (e) {
            var content = $(status);
            var title = content.filter('title');
            if(title.length > 0) {
                MagicModal.$modal.find('.modal-title').html(title.html());
            }
            // reinitPlugins();
        }
    });
    //подгрузка контента с удаленного роута
    $magicModalPjax.on('pjax:end', function(object, xhr) {
        if(xhr.status != 200) {
            return;
        }

        if(MagicModal.isJsonResponse) {
            return;
        }

        // var panels = $('#magic-modal').find('.panel');
        // $.each(panels, function(el) {
        //     el.removeClass
        // });
        // $magicModalPjax.find('.panel').removeClass('panel')
        MagicModal.$modal.modal('show');
    });

    $magicModalPjax.on('pjax:error', function (xhr, response) {
        MagicModal.reset();
        var message = response.status + ' : ' + response.statusText;
        componentNotify.pNotify(componentNotify.statuses.error, message);

        return false;
    });
});