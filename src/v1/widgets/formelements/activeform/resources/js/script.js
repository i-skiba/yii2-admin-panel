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
});