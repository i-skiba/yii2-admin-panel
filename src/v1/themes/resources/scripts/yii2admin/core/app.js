var yii2admin = {
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
    runCallback : function(string, data) {
        var wrap = s => "{ return " + string.trim() + " };"
        var func = new Function( wrap(string) );
        try{
            func.call(null).call(null, data);
        } catch(e) {}
    }
};
// todo: реализовать частые функции
var callbackHelper = {
    reloadList: function(id) {
        $.pjax.reload('#' + id);
    }
};

var FlashAlertHelper = {
    interval : null,
    container : null,
    duration : 7000,
    show : function( response ) {
        this.container.html('');
        if(typeof response.flash !== 'undefined') {
            data = response.flash;
        } else {
            data = response;
        }

        if(! data) {
            return false;
        }

        this.container.html(data);

        return this.hide();
    },
    hide : function() {
        var self = this;
        self.reset();

        return setTimeout(
            function() {
                self.container.html('');
            } ,
            self.duration
        );
    },
    reset : function() {
        clearTimeout(this.interval);
    },
    initialization : function () {
        this.container = $('.admin-flash');
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

$(document).ready(function() {
    FlashAlertHelper.initialization();
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

    // инициализация плагинов
    componentChekboxes.uniform();
    componentChekboxes.switchery();
    componentChekboxes.bootstrap();
    componentSelects.uniform();

    // убиваем таймаут
    $('#list-pjax').on('pjax:timeout', function (event, data) {
        event.preventDefault()
    });

    // по завершению обновления листа реинициализируем плагины
    $('#list-pjax').on('pjax:end', function() {
        componentChekboxes.bootstrap();
        componentChekboxes.uniform();
        componentSelects.uniform();
        if(typeof componentCdnUploader !== 'undefined') {
            componentCdnUploader.initialization();
        }

        App.initCardActions();
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
            yii2admin.sendRequest(action, data.pjaxId, data.pjaxUrl, data.params, data.callback)
        }

        componentNotify.sweetAlert(data.swal, function () {
            yii2admin.sendRequest(action, data.pjaxId, data.pjaxUrl, data.params, data.callback)
        });
    });
});