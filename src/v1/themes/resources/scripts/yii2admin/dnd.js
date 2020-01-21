/* ------------------------------------------------------------------------------
 *
 *  # Dragula - drag and drop library
 *
 *  Demo JS code for extension_dnd.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var componentDragAndDrop = function() {

    var _componentDragula = function() {
        if (typeof dragula == 'undefined') {
            console.warn('Warning - dragula.min.js is not loaded.');
            return;
        }

        var drake = dragula([document.querySelector('.dnd-grid-view')], {
            mirrorContainer: document.querySelector('.dnd-grid-view tr'),
        });

        drake.on('drop', function (el, target, source, sibling) {
            var $container = $(target);
            var $elements = $container.find("tr").not( ".gu-mirror" );
            var sort = [];
            $.each($elements, function(index, target) {
                sort[index] = $(this).attr('data-key');
            });
            yii2admin.sendRequest(
                $container.attr('data-url'),
                {
                    'sort' : sort
                },
                {
                    'pjax_id' : 'list-pjax'
                }
            );

        });
    };

    return {
        init: function() {
            _componentDragula();
        }
    }
}();
