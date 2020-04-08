$(document).ready(function() {
    yii2admin.activeForm = {
        validateAttribute : {
            timeout: null,
            duration: 300,
            selector: '.active-form-validate-attribute',
            run: function ($element) {
                var $form = $element.closest('form');
                var $container = $element.closest('.form-group');
                var clasees = $container.attr('class');

                if($(this).closest('.dynamicform_wrapper').length > 0) {
                    var matches = clasees.match(/field\-([a-z_]+)\-[0-9]+\-[a-z_0-9]+/);
                } else {
                    var matches = clasees.match(/field\-[a-z]+\-([a-z_0-9]+)/);
                }

                if(matches == null) {
                    return;
                }

                var elSelector = matches[0];
                var attribute = matches[1];
                var $hidden = $form.find(yii2admin.activeForm.validateAttribute.selector);
                $hidden.val(attribute);
                clearInterval(yii2admin.activeForm.validateAttribute.timeout);
                var run = function() {
                    yii2admin.showPreloader = false;
                    yii2admin.sendRequest($form.attr('action'), $form.serialize(), {'type' : 'POST'}, function (html) {
                        var $html = $(html);
                        var $replaceableEl = $container.find('.text-danger');
                        var $replacementEl = $html.find('.' + elSelector + ' .text-danger');
                        if( $replacementEl.length === 1 && $replaceableEl.length === 1) {
                            $replaceableEl.replaceWith($replacementEl);
                        }

                        $hidden.val('');
                        yii2admin.showPreloader = true;
                    });
                };
                yii2admin.activeForm.validateAttribute.timeout = setTimeout(run, yii2admin.activeForm.validateAttribute.duration);
            }
        },
        refresh: function (object) {
            var form = object.closest('form');
            form.find('.active-form-refresh-value').val('vazgen');
            object.closest('.active-form-dependent-container').nextAll().remove();
            form.submit();
        }
    };

    $(document).off('change', '.active-form-refresh-control');
    $(document).on('change', '.active-form-refresh-control', function(event) {
        yii2admin.activeForm.refresh($(this));
    });
    $(document).off('switchChange.bootstrapSwitch', '.active-form-refresh-control');
    $(document).on('switchChange.bootstrapSwitch', '.active-form-refresh-control', function (e, state) {
        yii2admin.activeForm.refresh($(this));
    });

    $("form[data-validate-attribute-form]").off('keyup change paste', 'input, select, textarea');
    $("form[data-validate-attribute-form]").on('keyup change paste', 'input, select, textarea', function() {
        yii2admin.activeForm.validateAttribute.run($(this));
    });
});