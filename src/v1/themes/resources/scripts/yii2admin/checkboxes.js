var componentChekboxes = (function() {
    return {
        uniform: function () {
            if (! $().uniform) {
                console.warn('Warning - uniform.min.js is not loaded.');

                return;
            }

            var map = [
                {
                    'selector' : '.form-input-styled'
                },
                {
                    'selector' : '.form-check-input-styled'
                },
                {
                    'selector' : '.form-check-input-styled-primary',
                    'options' : {wrapperClass: 'border-primary-600 text-primary-800'}
                },
                {
                    'selector' : '.form-check-input-styled-danger',
                    'options' : {wrapperClass: 'border-danger-600 text-danger-800'}
                },
                {
                    'selector' : '.form-check-input-styled-success',
                    'options' : {wrapperClass: 'border-success-600 text-success-800'}
                },
                {
                    'selector' : '.form-check-input-styled-warning',
                    'options' : {wrapperClass: 'border-success-600 text-success-800'}
                },
                {
                    'selector' : '.form-check-input-styled-info',
                    'options' : {wrapperClass: 'border-info-600 text-info-800'}
                },
                {
                    'selector' : '.form-check-input-styled-custom',
                    'options' : {wrapperClass: 'border-pink-600 text-pink-800'}
                },
            ];

            map.forEach(function(object){
                var $elements = initHelper.findElelements(object.selector);
                if($elements !== null && $elements.length > 0) {
                    $elements.uniform(object.options || {});
                    initHelper.initElements($elements);
                }
            });
        },
        switchery: function () {
            if (typeof Switchery == 'undefined') {
                console.warn('Warning - switchery.min.js is not loaded.');

                return;
            }

            // Initialize multiple switches
            var elems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html);
            });

            // Colored switches
            var primary = document.querySelector('.form-check-input-switchery-primary');
            if (null !== primary) {
                var switchery = new Switchery(primary, {color: '#2196F3'});
            }

            var danger = document.querySelector('.form-check-input-switchery-danger');
            if (null !== danger) {
                var switchery = new Switchery(danger, {color: '#EF5350'});
            }

            var warning = document.querySelector('.form-check-input-switchery-warning');
            if (null !== warning) {
                var switchery = new Switchery(warning, {color: '#FF7043'});
            }

            var info = document.querySelector('.form-check-input-switchery-info');
            if (null !== info) {
                var switchery = new Switchery(info, {color: '#00BCD4'});
            }
        },
        bootstrap: function () {
            if (!$().bootstrapSwitch) {
                console.warn('Warning - switch.min.js is not loaded.');

                return;
            }

            var selector = '.form-check-input-switch';
            var $elements = initHelper.findElelements(selector);
            if($elements === null || $elements.length === 0) {
                return;
            }

            $elements.bootstrapSwitch();
            initHelper.initElements($elements);
        },
        initAll : function() {
            this.uniform();
            this.switchery();
            this.bootstrap();
        }
    }
})();
