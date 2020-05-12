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
            var options = $(this).data('plugin-options');
            $(this).select2(options);
        });

        $elements.on('select2:clearing', function (e) {
            e.preventDefault();
            var self = $(this);

            componentNotify.sweetAlert(yii2admin.t('Confirm'), function () {
                self.val(null).trigger("change");
                self.select2("open");
            });

        });
        initHelper.initElements($elements);
    };

    Select2.prototype.registerEvents = function () {
        var $select = null,
            $smartInput = null;

        $(document).on('click', '.select2-smart-input', function() {
            $select = $(this).prev('.select2');
            $smartInput = $(this);
            $smartInput.addClass('d-none');
            instance.initElements($select);
            $select.select2("open");
        });
    };

    $(document).ready(function() {
        instance = componentSelects.select2 = function() {
            var selector = '.select2[data-smart-select!="true"]',
                $elements = initHelper.findElelements(selector);

            instance = new Select2(selector);
            instance.initElements($elements);

            return instance;
        }();

        instance.registerEvents();
    });
})();