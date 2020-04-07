var Yii2Admin = function() {
    this.i18n = {
        dictionary : {},
        extend : function (object) {
            this.dictionary = _.extend(this.dictionary, object);
        }
    };
    this.showPreloader = true;
    this.formChanged = false;
    this.enableFormChangedAlert = true;
    this.changeLockCheckUrl = '/admin/changelock/change-lock/check';
    this.changeLockAfkLimit = 20;
    this.enableChangeLock = false;
};

Yii2Admin.prototype.setChangeLockEvents = function (key) {
    if (! self.enableChangeLock) {
        return;
    }

    let self = this;
    var lastActionDate = new Date();
    var checkLockInterval = null;
    $(document).on('mousemove', '*', function(event) {
        lastActionDate = new Date();
        return true;
    });

    $(document).on('keypress', '*', function(event) {
        lastActionDate = new Date();
        return true;
    });

    let urlArray = window.location.pathname.split('/');
    let action = urlArray[urlArray.length-1];
    if (action !== 'update'){
        return;
    }

    this.check = function(){
        let currentDate = new Date();
        let timeDiff = Math.abs(currentDate.getTime() - lastActionDate.getTime());
        var diffMins = Math.ceil(timeDiff / (1000 * 60));
        /**
         * if diff > self.changeLockAfkLimit stop checkLockInterval
         */
        if (diffMins > self.changeLockAfkLimit){
            clearInterval(checkLockInterval);
            return;
        }

        self.showPreloader = false;
        self.sendRequest(self.changeLockCheckUrl, {}, {}, function (data) {
            console.log(data);
        });
        self.showPreloader = true;
    };
    self.check();
    checkLockInterval = setInterval(function() {
        self.check();
    }, 10000);
};

Yii2Admin.prototype.setFormChangedEvents = function (key) {
    let self = this;
    if (! self.enableFormChangedAlert) {
        return;
    }

    window.onbeforeunload = function() {
        if(self.formChanged) {
            return true;
        }

        return null;
    };

    $(document).on('submit', '*', function(event) {
        self.formChanged = false;
        return true;
    });

    $('form').on('keyup change paste', 'input, select, textarea', function(){
        self.formChanged = true;
    });

    $('form').find('input[type=hidden]').each(function (e) {
        $(document).on('change', this,  function(e) {
            self.formChanged = true;
        });
    });
};


Yii2Admin.prototype.t = function (key) {
    if(typeof this.i18n.dictionary[key] === 'undefined') {
        return null;
    }

    return  this.i18n.dictionary[key];
};

Yii2Admin.prototype.sendRequest = function (action , params, options, callback) {
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

            if(typeof options.pjax_id !== 'undefined') {
                var pjaxOptions = {
                    push : false,
                    replace : false
                };
                if(typeof options.pjax_url !== 'undefined') {
                    pjaxOptions['url'] = options.pjax_url;
                }

                $.pjax.reload('#' + options.pjax_id , pjaxOptions);
                self.notify(response);
            }

            if(typeof callback !== 'undefined') {
                self.runCallback(callback, response)
            }

            if(typeof response.redirectUrl !== 'undefined') {
                location.href = response.redirectUrl;
            }

        }, error : function(data) {
            // alert(data);
            var messaga = data.status + ' : ' + data.statusText;
            componentNotify.pNotify(componentNotify.statuses.error, messaga);
        }
    });
};

Yii2Admin.prototype.notify = function(response) {
    if(typeof response.flash !== 'undefined') {
        flashAlert.interval = flashAlert.show(response);
    }

    if(
        typeof response.type !== 'undefined'
        && typeof response.message !== 'undefined'
    ) {
        componentNotify.pNotify(response.type, response.message);
    }
};
// рецепт, понаблюдать
Yii2Admin.prototype.runCallback = function(callback, data) {
    if(typeof callback === 'function') {
        return eval(callback)(data);
    }

    var wrap = s => "{ return " + callback.trim() + " };";
    var func = new Function( wrap(callback) );
    try{
        func.call(null).call(null, data);
    } catch(e) {}
};

Yii2Admin.prototype.reinitPlugins = function() {
    componentChekboxes.uniform();
    componentChekboxes.switchery();
    componentChekboxes.bootstrap();
    componentSelects.uniform();
    componentDragAndDrop.init();
    if(typeof componentCdnUploader !== 'undefined') {
        componentCdnUploader.initialization();
    }

    App.initCardActions();
};

var FlashAlertHelper = function() {
    // todo: криво пашет, скрывает сразу
    // this.interval = this.hide();
    this.interval = null;
    this.$container = $('.admin-flash');
    this.duration = 7000;
};

FlashAlertHelper.prototype.show = function( response ) {
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
};

FlashAlertHelper.prototype.hide = function() {
    var self = this;
    self.reset();

    return setTimeout(
        function() {
            self.$container.html('');
        } ,
        self.duration
    );
};

FlashAlertHelper.prototype.reset = function() {
    clearTimeout(this.interval);
};

var UrlHelper = function() {};

UrlHelper.prototype.addParam = function(queryString, param, value) {
    queryParameters = this._getQueryParameters(queryString);
    queryParameters[param] = value;

    return $.param(queryParameters);
};

UrlHelper.prototype.removeParam = function(queryString, param) {
    queryParameters = this._getQueryParameters(queryString);
    delete queryParameters[param];

    return $.param(queryParameters);
};

UrlHelper.prototype._getQueryParameters = function(queryString) {
    var queryParameters = {}, re = /([^&=]+)=([^&]*)/g, m;
    while (m = re.exec(queryString)) {
        queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
    }

    return queryParameters;
};

var Pjax = function() {
    this.selector = '#list-pjax';
    this.settings = {
        push : false,
        scrollTo : false,
        replace : false
    };
};

Pjax.prototype.setSelector = function(value) {
    this.selector = value;
};

Pjax.prototype.setSettings = function(object) {
    this.settings = object;
};

Pjax.prototype.extendSettings = function(object) {
    this.settings = _.extend(this.settings, object);
};

Pjax.prototype.reload = function() {
    $.pjax.reload(this.selector, this.settings);
};

Pjax.prototype.submit = function(event) {
    $.pjax.submit(event, this.selector, this.settings);
};

var MagicModal = function() {
    this.$modal = $('#magic-modal');
    this.$container = null;
    this.modalSizes = [
        'modal-full',
        'modal-lg',
        'modal-sm',
        'modal-xs'
    ];
    this.response = null;
    this.isJsonResponse = false;
    this.isStop = false;
    this.callback = null;
    if(this.$modal.length > 0) {
        this.$container = this.$modal.find('.modal-dialog');
    }

    this.pjax = new Pjax();
    this.pjax.setSelector('#magic-modal-pjax');
};

MagicModal.prototype.run = function($el) {
    if(typeof this.pjax.settings.data !== 'undefined') {
        this.pjax.settings.data = {};
    }

    this.isStop = false;
    var data = $el.data();
    this.applySize( data.modalSize );
    this.setCallback( data.callback );
    this.pjax.extendSettings({url : data.url});
    //если элемент находится в форме
    // todo : всю форму нельзя сериализовать
    // var $serializeElement = $el.closest('form');
    var $serializeElement;
    if(typeof $serializeElement !== 'undefined' && $serializeElement.length === 0) {
        var selector = data.serializeSelector;
        if(typeof selector !== 'undefined') {
            //TODO реализовать пригодится
            //parts = selector.split('||');
            $serializeElement = $(selector);
        }
    }

    var formData = null;
    //TODO сбор данных с более одного селектора
    if(typeof $serializeElement !== 'undefined' && $serializeElement.length === 1) {
        formData = $serializeElement.serialize();
        //удаление параметра _csrf из серилизованной строки
        formData = formData.replace( /_csrf=(.*?)\&/g, "" );
        this.pjax.extendSettings({data : formData});
        delete this.pjax.settings.data['_csrf'];
    }

    this.pjax.reload();
};

MagicModal.prototype.applySize = function(size_class) {
    this.$container.removeClass(this.modalSizes.join(' '));
    if(
        typeof size_class !== 'undefined'
        || ! this.$container.hasClass(size_class)
    ) {
        this.$container.addClass(size_class);
    }
};

MagicModal.prototype.setCallback = function(value) {
    if(typeof value == 'undefined') {
        return false;
    }

    this.callback = value
};

MagicModal.prototype.stop = function() {
    this.callback = null;
    this.isJsonResponse = false;
    this.response = null;
    this.isStop = true;
};

var CallbackHelper = function() {
    this.pjax = new Pjax();
};

CallbackHelper.prototype.reloadPjax = function(selector) {
    this.pjax.setSelector(selector);
    this.pjax.reload();
};

var yii2admin = new Yii2Admin();
var magicModal = new MagicModal();
var callbackHelper = new CallbackHelper();
var urlHelper = new UrlHelper();
var flashAlert = new FlashAlertHelper();

$(document).ready(function() {
    componentChekboxes.uniform();
    componentChekboxes.switchery();
    componentChekboxes.bootstrap();
    componentSelects.uniform();
    componentDragAndDrop.init();
    $('.history-back').click(function() {
        window.history.back();
    });

    yii2admin.setFormChangedEvents();
    yii2admin.setChangeLockEvents();

    // preloader при ajax запросах
    $(document)
        .ajaxStart(function() {
            if(! yii2admin.showPreloader) {
                return;
            }

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
        if(! yii2admin.showPreloader) {
            return;
        }

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

        yii2admin.reinitPlugins();
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
        flashAlert.reset();
        var action = $(this).attr('href');
        var data = $(this).data();
        if(typeof data.params !== 'undefined') {
            data.params = JSON.parse(data.params);
        }

        if(typeof action === 'undefined') {
            return false;
        }

        var options = {
            pjax_id: data.pjaxId,
            pjax_url: data.pjaxUrl,
        };

        if(typeof data.swal === 'undefined') {
            return yii2admin.sendRequest(action, data.params, options, data.callback)
        }

        componentNotify.sweetAlert(data.swal, function () {
            yii2admin.sendRequest(action, data.params, options, data.callback)
        });
    });

    var $magicModalPjax = $(magicModal.pjax.selector);
    $(document).on('click', '.magic-modal-control', function(e) {
        e.preventDefault();
        magicModal.run($(this))
    });

    $(document).on('submit', magicModal.pjax.selector + ' form', function(event) {
        var $form = $(this);
        magicModal.pjax.extendSettings({ url: $form.attr('action')});
        delete magicModal.pjax.settings.data;
        magicModal.pjax.submit(event);

        return true;
    });

    $magicModalPjax.on('pjax:timeout', function (event, data) {
        event.preventDefault();
    });

    $magicModalPjax.on('pjax:success', function(data, status, xhr, options) {
        try {
            var response = $.parseJSON(status);
            magicModal.isJsonResponse = true;
            yii2admin.notify(response);
            if(magicModal.callback !== null) {
                yii2admin.runCallback(magicModal.callback, response.data);
            }


            magicModal.$modal.modal('hide');
            magicModal.stop();
        } catch (e) {
            var content = $(status);
            var title = content.filter('title');
            if(title.length > 0) {
                magicModal.$modal.find('.modal-title').html(title.html());
            }

            yii2admin.reinitPlugins();
        }

        return true;
    });
    //подгрузка контента с удаленного роута
    $magicModalPjax.on('pjax:end', function(object, xhr) {
        if(xhr.status != 200 || magicModal.isJsonResponse) {
            return true;
        }

        if(! magicModal.isStop) {
            // $magicModalPjax.find('.card').each(function(el) {
            //     $(this).removeClass('card');
            // });
            magicModal.$modal.modal('show');
        }

        return true;
    });

    $magicModalPjax.on('pjax:error', function (xhr, response) {
        // случаи с abort
        if(response.status == 0) {
            return true;
        }

        var message = response.status + ' : ' + response.statusText;
        componentNotify.pNotify(componentNotify.statuses.error, message);
        magicModal.stop();

        return false;
    });

    $(document).on("afterInsert", ".dynamicform_wrapper", function () {
        yii2admin.reinitPlugins();
    });

    $(document).on("limitReached", ".dynamicform_wrapper", function (e, item) {
        $container = $(e.target);
        $button = $container.find('.dynamic-form-add-item');
        if($button.length === 0) {
            return true;
        }

        message = $button.attr('data-message');
        if(message === undefined) {
            return true;
        }

        componentNotify.pNotify(componentNotify.statuses.info, message + ' - ' + item);
    });
});