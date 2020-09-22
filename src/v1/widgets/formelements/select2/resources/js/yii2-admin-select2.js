(function() {
    var instance = null;
    var Select2 = function(selector) {
        this.selector = selector;
    };

    Select2.prototype.initElements = function($elements) {
        if (
            $elements === null
            || $elements.length === 0
        ) {
            return;
        }

        $elements.each(function() {
            var variable = $(this).data('plugin-options-variable'),
                options = window[variable] || {},
                $element = $(this);

            if(! initHelper.isInit($element)) {
                $element.select2(options);
                $element.on('select2:clearing', function (e) {
                    e.preventDefault();
                    var self = $(this);

                    componentNotify.sweetAlert(yii2admin.t('Confirm'), function () {
                        self.val(null).trigger("change");
                        self.select2("open");
                    });

                });

                initHelper.initElements($element);
            }
        });
    };

    Select2.prototype.initSmartElements = function () {
        var $select = null,
            $smartInput = null,
            self = this;

        $(document).on('click', '.select2-smart-input', function() {
            $select = $(this).prev('.select2');
            $smartInput = $(this);
            $smartInput.addClass('d-none');
            self.initElements($select);
            $select.select2("open");
        });
    };

    $(document).ready(function() {
        var selector = 'select.select2[data-smart-select!="true"]',
            $elements = initHelper.findElelements(selector),
            instance = new Select2(selector);

        componentSelects.select2 = instance;
        instance.initElements($elements);
        instance.initSmartElements();
    });
})();