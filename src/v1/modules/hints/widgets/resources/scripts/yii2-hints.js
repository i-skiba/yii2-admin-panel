$(document).ready(function () {
    Yii2Admin.prototype.showAdminHints = function (json) {
        _.each(json, function(value) {
            var hint = $('#yii2admin_hint_' + value.name);
            hint.attr('data-original-title', value.caption);
            hint.attr('data-content', value.value);
            hint.removeClass('d-none');
        });
    };
    var $elements = $('.yii2admin_hints');
    $elements.popover();

    $(document).on('click', function(e) {
        var $target = $(e.target);
        if(
            ! $target.hasClass('yii2admin_hints')
            && $target.closest('.popover').length === 0
        ) {
            $elements.popover('hide');
        }
    })
    // $('.yii2admin_hints').on('click', function() {
    //     var title = $(this).attr('data-title');
    //     var content = $(this).attr('data-content');
    //     var init = $(this).attr('data-init');
    //     var self = $(this);
    //     if(init === false) {
    //         self.popover({
    //             title: title,
    //             content: content,
    //             trigger: 'click',
    //             html: true
    //         });
    //         self.attr('data-init', true);
    //     }
    //
    //     self.popover('show');
    // });
})