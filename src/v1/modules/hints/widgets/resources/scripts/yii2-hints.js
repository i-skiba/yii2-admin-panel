$(document).ready(function () {
    yii2admin.popover = {
        class: 'yii2admin_hints',
        elements: {},
        is_show: false
    };

    Yii2Admin.prototype.initAdminHints = function (json) {
        yii2admin.popover.elements = $('.' + yii2admin.popover.class);
        _.each(json, function(value) {
            var hint = $('#yii2admin_hint_' + value.name);
            hint.attr('data-original-title', value.caption);
            hint.attr('data-content', value.value);
            hint.removeClass('d-none');
        });

        yii2admin.popover.elements.popover();
        yii2admin.popover.elements.off('show.bs.popover');
        yii2admin.popover.elements.on('show.bs.popover', function () {
            yii2admin.popover.elements.popover('hide');
            yii2admin.popover.is_show = true;
        })
    };

    $(document).on('click', function(e) {
        var $target = $(e.target);
        var is_hint = $target.hasClass(yii2admin.popover.class);
        if(
            ! is_hint
            && $target.closest('.popover').length === 0
            && yii2admin.popover.is_show === true
        ) {
            yii2admin.popover.elements.popover('hide');
            yii2admin.popover.is_show = false;
        }

        if(is_hint) {
            return false;
        }
    });
});