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

        var clasees = $(this).attr('class');
        var matches = clasees.match(/field\-[a-z]+\-([a-z_]+)/);
        var attribute = matches[1];
        form.find('.active-form-validate-attribute').val(attribute);
        yii2admin.showPreloader = false;
        form.submit();
    });

    $('#list-pjax').on('pjax:end', function(object, xhr) {
        $('.active-form-validate-attribute').val('');
        yii2admin.showPreloader = true;
    });
});