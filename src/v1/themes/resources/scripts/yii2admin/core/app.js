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
    this.updateLockUrl = null;
    this.checkLockUrl = null;
    this.changeLockAfkLimit = 20;
    this.enableChangeLock = true;
};

Yii2Admin.prototype.setChangeLockEvents = function (key) {
    let self = this;
    if (! self.enableChangeLock) {
        return;
    }

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

    this.lockForm = function(message){
        componentNotify.pNotify(componentNotify.statuses.warning, message, {hide:false});
        $('form').find('button[type=submit]').each(function (e) {
            $(this).closest('.card').remove();
        });
    };

    this.getMetaValue = function (metaName) {
        const metas = document.getElementsByTagName('meta');
        for (let i = 0; i < metas.length; i++) {
            if (metas[i].getAttribute('name') === metaName) {
                return metas[i].getAttribute('content');
            }
        }

        return null;
    }

    this.getUrl = function(){
        let url = window.location.href;
        url = window.location.href.replace(window.location.origin + '/', '');
        let updateUrl= self.getMetaValue('update_url');
        if (updateUrl !== null) {
            return  updateUrl;
        }

        return url;
    };

    this.update = function(){
        if(self.updateLockUrl === null) {
            self.updateLockUrl = $('body').data('change-lock-update-url');
        }

        let currentDate = new Date();
        let timeDiff = Math.abs(currentDate.getTime() - lastActionDate.getTime());
        var diffMins = Math.ceil(timeDiff / (1000 * 60));
        /**
         * if diff > self.changeLockAfkLimit stop checkLockInterval
         */
        if (diffMins > self.changeLockAfkLimit){
            clearInterval(checkLockInterval);
            self.lockForm(yii2admin.t('EditBlockMessage'));
            return;
        }

        self.showPreloader = false;
        let url = self.getUrl();
        self.sendRequest(self.updateLockUrl, {'url': url}, {}, function (data) {});
        self.showPreloader = true;
    };

    this.check = function(){
        if(self.checkLockUrl === null) {
            self.checkLockUrl = $('body').data('change-lock-check-url');
        }

        self.showPreloader = false;
        let url = self.getUrl();
        self.sendRequest(self.checkLockUrl, {'url': url}, {}, function (data) {
            if (data['can'] == true){
                checkLockInterval = setInterval(function() {
                    self.update();
                }, 10000);

                return;
            }

            self.lockForm(yii2admin.t('СhangeUrlBlockMessage') + data['blocked_by'].username);
        });
        self.showPreloader = true;
    };

    self.check();
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

Yii2Admin.prototype.sendRequest = function (action , params = {}, options = {}, callback) {
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
    componentChekboxes.initAll();
    componentSelects.initAll();
    componentDragAndDrop.init();
    if(typeof componentCdnUploader !== 'undefined') {
        componentCdnUploader.initialization();
    }

    this.reinitLimitlessPlugins();
};
//todo: умный реинит
Yii2Admin.prototype.reinitLimitlessPlugins = function() {
    $('.card [data-action=collapse]').off('click');
    App.initCardActions();
};

Yii2Admin.prototype.inViewport = function(el) {
    var rect = el.getBoundingClientRect();

    return rect.bottom > 0 &&
        rect.right > 0 &&
        rect.left < (window.innerWidth || document.documentElement.clientWidth) /* or $(window).width() */ &&
        rect.top < (window.innerHeight || document.documentElement.clientHeight) /* or $(window).height() */;
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

UrlHelper.prototype.getParam = function(queryString, param) {
    var queryParameters = this.getQueryParameters(queryString);

    return queryParameters[param] ?? null;
};

UrlHelper.prototype.addParam = function(queryString, param, value) {
    var queryParameters = this.getQueryParameters(queryString);

    queryParameters[param] = value;

    return queryString.split('?')[0] + "?" + $.param(queryParameters);
};

UrlHelper.prototype.removeParam = function(queryString, param) {
    var queryParameters = this.getQueryParameters(queryString);
    delete queryParameters[param];

    return queryString.split('?')[0] + "?" + $.param(queryParameters);
};

UrlHelper.prototype.getQueryParameters = function(queryString) {
    var
        queryParameters = {},
        re = /[?&]+([^=&]+)=([^&]*)/g,
        // re = /([^&=]+)=([^&]*)/g,
        m;

    while (m = re.exec(queryString)) {
        queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
    }

    return queryParameters;
};

UrlHelper.prototype.addDomainParam = function(queryString) {
    var currentUrl = location.href;
    var domain_id = this.getParam(currentUrl, 'domain_id');
    if(domain_id === null) {
        return queryString;
    }

    return this.addParam(queryString, 'domain_id', domain_id);
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

var MagicModal = function(selector, pjaxSelector, controlSelector) {
    this.selectors = {
        modal : selector
    };
    this.$modal = $(this.selectors.modal);
    this.$container = null;
    this.modalSizes = [
        'modal-full',
        'modal-lg',
        'modal-sm',
        'modal-xs'
    ];
    this.response = null;
    this.controlSelector = controlSelector;
    this.isJsonResponse = false;
    this.isStop = false;
    this.callback = null;
    this.onCloseCallback = null;
    if(this.$modal.length > 0) {
        this.$container = this.$modal.find('.modal-dialog');
    }

    this.controlCallStack = {};

    this.pjax = new Pjax();
    this.pjax.setSelector(pjaxSelector);
};

MagicModal.createInstance = function(selector, pjaxSelector, controlSelector) {
    var instance = new MagicModal(selector, pjaxSelector, controlSelector);

    instance.init();

    return instance;
};

MagicModal.prototype.setTitle = function(title) {
    this.$modal.find('.modal-title').html(title);
};

MagicModal.prototype.setBody = function(body) {
    this.$modal.find('.modal-body').html(body);
};

MagicModal.prototype.getBody = function() {
    return this.$modal.find('.modal-body').html();
};

MagicModal.prototype.show = function() {
    this.$modal.modal('show');
};

MagicModal.prototype.hide = function() {
    this.$modal.modal('hide');
};

MagicModal.prototype.close = function(runCallback = true) {
    // TODO : допилить
    // var keys = Object.keys(this.controlCallStack);
    // if(keys.length > 0) {
    //     var self = this,
    //         values = Object.values(this.controlCallStack),
    //         key = keys[keys.length-1],
    //         $value = values[values.length-1];
    //         self.run($value);
    // } else {
    if(runCallback && typeof this.onCloseCallback == 'function') {
        yii2admin.runCallback(this.onCloseCallback);
        this.onCloseCallback = null;
        this.$modal.off('hidden.bs.modal');
    }

    this.hide();
    this.stop();
    // }
};

MagicModal.prototype.onClose = function(callback) {
    var self = this;
    this.onCloseCallback = callback;
    this.$modal.on('hidden.bs.modal', function(e) {
        self.hide();
    });
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

MagicModal.prototype.pushControlCallStack = function($el) {
    var url = $el.data('url');

    if($el.closest(this.selectors.modal).length === 0 && url !== undefined) {
        this.controlCallStack[url] = $el;
    }
};

// инициализация событий pjax для модалки
MagicModal.prototype.init = function() {
    var mmInstance = this;
    var $magicModalPjax = $(mmInstance.pjax.selector);
    $(document).on('click', mmInstance.controlSelector, function(e) {
        e.preventDefault();
        var self = $(this);
        // TODO : допилить
        // magicModal.pushControlCallStack(self);
        mmInstance.run(self);
    });

    $(document).on('submit', mmInstance.pjax.selector + ' form', function(event) {
        var $form = $(this);
        mmInstance.pjax.extendSettings({ url: $form.attr('action')});
        delete mmInstance.pjax.settings.data;
        mmInstance.pjax.submit(event);

        return true;
    });

    $magicModalPjax.on('pjax:timeout', function (event, data) {
        event.preventDefault();
    });
    $magicModalPjax.on('pjax:beforeSend', function (data, xhr, pjax) {
        // экранирование только якоря
        pjax.url = decodeURIComponent(urlHelper.addDomainParam(pjax.url)).replace('#', '%23')
    });

    $magicModalPjax.on('pjax:success', function(data, status, xhr, options) {
        try {
            var response = $.parseJSON(status);
            mmInstance.isJsonResponse = true;
            yii2admin.notify(response);
            if(mmInstance.callback !== null) {
                yii2admin.runCallback(mmInstance.callback, response.data);
            }

            mmInstance.close();
        } catch (e) {
            var content = $(status);
            var title = content.filter('title');
            if(title.length > 0) {
                mmInstance.$modal.find('.modal-title').html(title.html());
            }

            yii2admin.reinitPlugins();
        }

        return true;
    });
    //подгрузка контента с удаленного роута
    $magicModalPjax.on('pjax:end', function(object, xhr) {
        if(xhr.status != 200 || mmInstance.isJsonResponse) {
            return true;
        }

        if(! mmInstance.isStop) {
            // $magicModalPjax.find('.card').each(function(el) {
            //     $(this).removeClass('card');
            // });
            //
            // $magicModalPjax.find('.card-body').each(function(el) {
            //     $(this).removeClass('card-body');
            // });

            mmInstance.$modal.modal('show');
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
        mmInstance.stop();

        return false;
    });
};

var CallbackHelper = function() {
    this.pjax = new Pjax();
};

CallbackHelper.prototype.reloadPjax = function(selector) {
    this.pjax.setSelector(selector);
    this.pjax.reload();
};


var InitHelper = function() {
    this.attribute  = 'data-state';
    this.value = 'init';
};

InitHelper.prototype.findElelements = function(selector) {
    var $el = $(selector + '[' + this.attribute + '!="' + this.value + '"]');
    if($el.length === 0) {
        return null;
    }

    return $el;
};

InitHelper.prototype.initElements = function(elements) {
    var self = this;

    if(typeof elements === 'string') {
        var $elements = $(elements);
    } else {
        var $elements = elements;
    }

    $elements.each(function(){
        $(this).attr(self.attribute, self.value);
    });
};

InitHelper.prototype.isInit = function (element) {
    var self = this;

    if(typeof element === 'string') {
        var $element = $(element);
    } else {
        var $element = element;
    }

    return $element.attr(self.attribute) === self.value;
};

var yii2admin = new Yii2Admin();
var magicModal = MagicModal.createInstance('#magic-modal', '#magic-modal-pjax', '.magic-modal-control');
var callbackHelper = new CallbackHelper();
var urlHelper = new UrlHelper();
var flashAlert = new FlashAlertHelper();
var initHelper = new InitHelper();

$(document).ready(function() {
    componentChekboxes.initAll();
    componentSelects.initAll();
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
    $listPjax.on('pjax:end', function(object, xhr, a, b) {
        var $error = $(document).find('.has-error').first();

        if($error.length > 0) {
            var el = $error.get(0);

            if(! yii2admin.inViewport(el)) {
                window.scrollTo(0, $error.offset().top);
            }
        }

        if(xhr.status != 200) {
            return;
        }

        // обновление переключения доменов в навигационной панели
        var $domainSidebar = $('.sidebar-content[data-current-domain-id]');

        if($domainSidebar.length === 1) {
            var currentDomainId = $domainSidebar.data('current-domain-id'),
            $domainNavBar = $('.domain-switch-navbar');

            if($domainNavBar.length === 1) {
                var $element = $domainNavBar.find('[data-domain-id="' + currentDomainId + '"]'),
                    $current = $domainNavBar.find('.domain-switch-navbar-current'),
                    content = $element.parent().html();

                if($current.length === 1) {
                    $domainNavBar.find('.switch-domain').removeClass('active');
                    $element.closest('.switch-domain ').addClass('active');
                    $current.html(content);
                }
            }
        }

        yii2admin.reinitPlugins();
    });

    $listPjax.on('pjax:error', function(xhr, response) {
        // случаи с abort
        if(response.status == 0) {
            return true;
        }

        var message = response.status + ' : ' + response.statusText;
        componentNotify.pNotify(componentNotify.statuses.error, message);

        return false;
    });

    // Поиск по grid-view / list-view
    $(document).on('submit', '.search-box form', function(event) {
        var magicModalSelector = '#magic-modal-pjax',
            updateSelector = '#list-pjax',
            isMagicModal = ($(this).closest(magicModalSelector).length === 1),
            options = {};

        if(isMagicModal) {
            updateSelector = magicModalSelector;
            options = {"push": false};
        }
        $.pjax.submit(event, updateSelector, options);
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