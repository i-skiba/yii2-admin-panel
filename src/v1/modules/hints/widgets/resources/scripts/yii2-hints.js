$(document).ready(function () {
    yii2admin.showPopover = false;
    Yii2Admin.prototype.initAdminHints = function (json) {
        _.each(json, function(value) {
            var hint = $('#yii2admin_hint_' + value.name);
            hint.attr('data-original-title', value.caption);
            hint.attr('data-content', value.value);
            hint.removeClass('d-none');
        });
    };

    var elementClass = 'yii2admin_hints';
    var $elements = $('.' + elementClass);
    $elements.popover();
    $(document).on('click', function(e) {
        var $target = $(e.target);
        var is_hint = $target.hasClass(elementClass);
        if(
            ! is_hint
            && $target.closest('.popover').length === 0
            && yii2admin.showPopover === true
        ) {
            $elements.popover('hide');
            yii2admin.showPopover = false;
        }

        if(is_hint) {
            return false;
        }
    });

    $elements.on('show.bs.popover', function () {
        $elements.popover('hide');
        yii2admin.showPopover = true;
    })
});