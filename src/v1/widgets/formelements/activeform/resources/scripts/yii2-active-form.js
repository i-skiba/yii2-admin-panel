$(document).ready(function() {
    yii2admin.activeForm = {
        validateAttribute : {
            formAtttribure: 'data-validate-attribute-form',
            actionCreate: 'create-validate-attribute',
            actionUpdate: 'update-validate-attribute',
            timeout: null,
            duration: 300,
            selector: '.active-form-validate-attribute',
            hiddenInput: null,
            run: function ($element) {
                var self = this;
                var $form = $element.closest('form');
                var $container = $element.closest('.form-group');

                if ($container.length === 0) {
                    return;
                }

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
                self.hiddenInput = $form.find(self.selector);

                self.hiddenInput.val(attribute);
                self.clearTimeout();

                var event = function() {
                    var url;
                    var action = $form.attr('action');
                    if(action.indexOf('/update?')) {
                        url = action.replace('update', self.actionUpdate);
                    } else {
                        url = action.replace('create', self.actionCreate);
                    }

                    yii2admin.showPreloader = false;
                    yii2admin.sendRequest(url, $form.serialize(), {'type' : 'POST'}, function (html) {
                        var $html = $(html);
                        var $replaceableEl = $container.find('.text-danger');
                        var $replacementEl = $html.find('.' + elSelector + ' .text-danger');

                        if( $replacementEl.length === 1 && $replaceableEl.length === 1) {
                            $replaceableEl.replaceWith($replacementEl);
                        }

                        self.hiddenInput.val('');
                        yii2admin.showPreloader = true;
                    });
                };

                self.timeout = setTimeout(event, self.duration);
            },
            clearTimeout: function() {
                clearTimeout(this.timeout);
            }
        },
        refresh: function ($object) {
            var $form = $object.closest('form');

            $form.find('.active-form-refresh-value').val('vazgen');
            $object.closest('.active-form-dependent-container').nextAll().remove();
            $form.submit();
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

    $(document).on('keyup change paste', 'input, select, textarea', function() {
        var $form = $(this).closest('form');
        if(
            $form.length === 0
            || $form.attr(yii2admin.activeForm.validateAttribute.formAtttribure) === undefined
        ) {
            return;
        }

        yii2admin.activeForm.validateAttribute.run($(this));
    });

    $(document).on('submit', 'form', function() {
        yii2admin.activeForm.validateAttribute.clearTimeout();
        if(yii2admin.activeForm.validateAttribute.hiddenInput !== null) {
            yii2admin.activeForm.validateAttribute.hiddenInput.val('');
        }
    });
    // alert('Разобраться')
    // console.log(editorHelper.editors);
    // _.each(editorHelper.editors, function(el, index) {
    //     var id = $(el.$oel).attr('id');
    //     console.log(id);
    //     $('#' . id).on('froalaEditor.contentChanged', function (e, editor) {
    //         alert(123);
    //     })
    // });
});