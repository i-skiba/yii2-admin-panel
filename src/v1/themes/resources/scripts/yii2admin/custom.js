$(document).ready(function() {
    // preloader при ajax запросах
    $(document)
        .ajaxStart(function(){
            $.blockUI({
                message: '<i class="icon-spinner4 spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    // color: '#fff',
                    padding: 0,
                    zIndex: 1201,
                    backgroundColor: 'transparent'
                }
            });
        }).ajaxStop(function(){
            $.unblockUI();
        });

    // инициализация плагинов
    componentChekboxes.uniform();
    componentChekboxes.switchery();
    componentChekboxes.bootstrap();
    componentSelects.uniform();


    // убиваем таймаут
    $('#list-pjax').on('pjax:timeout', function (event, data) {
        event.preventDefault()
    });
    // по завершению обновления листа реинициализируем плагины
    $('#list-pjax').on('pjax:end', function() {
        componentChekboxes.bootstrap();
        componentChekboxes.uniform();
        componentSelects.uniform();
        if(typeof componentCdnUploader !== 'undefined') {
            componentCdnUploader.initialization();
        }

        App.initCardActions();
    });

    // Поиск по grid-view / list-view
    $(document).on('submit', '.search-box form', function(event) {
        $.pjax.submit(event, '#list-pjax');
    });
    // Очистка полей поиска
    $(document).on('click','.search-clear' ,function(e){
        e.preventDefault();
        var form = $(this).closest('.search-box form');
        form.find('input[type="text"]').val('');
        //.row чтобы не сбрасывались системные hidden поля, а только поля формы поиска
        form.find('.row input[type="hidden"]').val('');
        form.find('select').val('');
        if($('.selectbox').length > 0) {
            $('.selectbox').data("selectBox-selectBoxIt").refresh();
        }

        form.find('input[type="checkbox"]').removeAttr('checked');
        // removeBootstrapClass();
        form.submit();
    });
});