var componentNotify = {
    statuses : {
        success : 'success',
        error : 'error',
        failure : 'error',
        warning : 'error',
        info : 'info',
        danger : 'danger'
    },
    alertClass : {
        success : 'alert-success',
        error : 'alert-warning',
        failure : 'alert-warning',
        warning : 'alert-warning',
        info : 'alert-info',
        danger : 'alert-danger'
    },
    pNotify : function(type, message) {
        if (typeof PNotify == 'undefined') {
            console.error('Warning - pnotify.min.js is not loaded.');
            return;
        }

        var opts = {
            // title: 'Left icon',
            text: (message !== undefined ? message :"Check me out. I'm in a different stack." ),
            addclass: 'alert alert-styled-left ' + this.alertClass[type],
            type: this.statuses[type]
        };

        return new PNotify(opts);
    },
    sweetAlert : function (message, callback) {
        if (typeof swal == 'undefined') {
            console.warn('Warning - sweet_alert.min.js is not loaded.');
            return;
        }

        var Swal = swal.mixin({
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-light'
        });

        Swal({
                title: message + " ?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: yii2admin.t('Confirm'),
                cancelButtonText: yii2admin.t('Cancel'),
        }).then(function (result) {
            if(! result.value) {
                return false;
            }

            callback.call();
        })
    }
};

