$(document).ready(function () {
    yii2admin.adminHints = {
        popover: {
            class: 'yii2admin_hints_popover',
            elements: [],
            is_show: false,
            type: 0
        },
        info : {
            class: 'yii2admin_hints_info',
            elements: [],
            type: 1
        }
    };

    Yii2Admin.prototype.initAdminHints = function (json) {
        _.each(json, function(value) {
            var hint = $('#yii2admin_hint_' + value.name);
            switch (value.type) {
                case yii2admin.adminHints.info.type :
                    hint.html(value.value);
                    break;
                default:
                    hint.attr('data-original-title', value.caption);
                    hint.attr('data-content', value.value);

                    hint.popover();
                    hint.off('show.bs.popover');
                    hint.on('show.bs.popover', function () {
                        $('.' + yii2admin.adminHints.popover.class).popover('hide');
                        yii2admin.adminHints.popover.is_show = true;
                    });
                    break
            }

            hint.attr('data-type', value.type);
            hint.removeClass('d-none');
        });
    };

    $(document).on('click', function(e) {
        var $target = $(e.target);
        var is_hint = $target.hasClass(yii2admin.adminHints.popover.class);
        if(
            ! is_hint
            && $target.closest('.popover').length === 0
            && yii2admin.adminHints.popover.is_show === true
        ) {
            $('.' + yii2admin.adminHints.popover.class).popover('hide');
            yii2admin.adminHints.popover.is_show = false
        }

        if(is_hint) {
            return false;
        }
    });
});