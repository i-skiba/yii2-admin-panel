var componentChekboxes = {

    uniform : function() {
        if (!$().uniform) {
            console.warn('Warning - uniform.min.js is not loaded.');
            return;
        }

        //single default
        $('.form-input-styled').uniform();
        // Default initialization
        $('.form-check-input-styled').uniform();

        // Primary
        $('.form-check-input-styled-primary').uniform({
            wrapperClass: 'border-primary-600 text-primary-800'
        });

        // Danger
        $('.form-check-input-styled-danger').uniform({
            wrapperClass: 'border-danger-600 text-danger-800'
        });

        // Success
        $('.form-check-input-styled-success').uniform({
            wrapperClass: 'border-success-600 text-success-800'
        });

        // Warning
        $('.form-check-input-styled-warning').uniform({
            wrapperClass: 'border-warning-600 text-warning-800'
        });

        // Info
        $('.form-check-input-styled-info').uniform({
            wrapperClass: 'border-info-600 text-info-800'
        });

        // Custom color
        $('.form-check-input-styled-custom').uniform({
            wrapperClass: 'border-pink-600 text-pink-800'
        });

        // Custom color
        $('.form-check-input-styled-custom').uniform({
            wrapperClass: 'border-pink-600 text-pink-800'
        });
    },
    switchery: function() {
        if (typeof Switchery == 'undefined') {
            console.warn('Warning - switchery.min.js is not loaded.');
            return;
        }

        // Initialize multiple switches
        var elems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });

        // Colored switches
        var primary = document.querySelector('.form-check-input-switchery-primary');
        if(null !== primary) {
            var switchery = new Switchery(primary, { color: '#2196F3' });
        }

        var danger = document.querySelector('.form-check-input-switchery-danger');
        if(null !== danger) {
            var switchery = new Switchery(danger, { color: '#EF5350' });
        }

        var warning = document.querySelector('.form-check-input-switchery-warning');
        if(null !== warning) {
            var switchery = new Switchery(warning, {color: '#FF7043'});
        }

        var info = document.querySelector('.form-check-input-switchery-info');
        if(null !== info) {
            var switchery = new Switchery(info, {color: '#00BCD4'});
        }
    },
    bootstrap : function() {
        if (!$().bootstrapSwitch) {
            console.warn('Warning - switch.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-check-input-switch').bootstrapSwitch();
    }
};
