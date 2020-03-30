$(document).ready(function() {
    $(document).off('change', '.active-form-refresh-control');
    $(document).on('change', '.active-form-refresh-control', function(event) {
        refreshActiveForm($(this));
    });
    $(document).off('switchChange.bootstrapSwitch', '.active-form-refresh-control');
    $(document).on('switchChange.bootstrapSwitch', '.active-form-refresh-control', function (e, state) {
        refreshActiveForm($(this));
    });

    function refreshActiveForm(object) {
        var form = object.closest('form');
        form.find('.active-form-refresh-value').val('vazgen');
        object.closest('.active-form-dependent-container').nextAll().remove();
        form.submit();
    }

    $(document).on('blur', 'form .form-group', function() {
        var form = $(this).closest('form');
        if(typeof form.attr('data-validate-attribute-form') === 'undefined') {
            return;
        }

        var self = $(this);
        var attributeSelector = '.active-form-validate-attribute';
        var clasees = $(this).attr('class');
        var matches = clasees.match(/field\-[a-z]+\-([a-z_]+)/);
        var elSelector = matches[0];
        var attribute = matches[1];

        $hidden = form.find(attributeSelector)
        $hidden.val(attribute);
        yii2admin.showPreloader = false;
        yii2admin.sendRequest(form.attr('action'), form.serialize(), {'type' : 'POST'}, function (html) {
            var $html = $(html);
            var $replaceableEl = self.find(' .text-danger');
            var $replacementEl = $html.find('.' + elSelector + ' .text-danger');
            if( $replacementEl.length === 1 && $replaceableEl.length === 1) {
                $replaceableEl.replaceWith($replacementEl);
            }

            $hidden.val('');
            yii2admin.showPreloader = true;
        });
    });
});