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
    fire : function(type, message) {
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
    }
};

