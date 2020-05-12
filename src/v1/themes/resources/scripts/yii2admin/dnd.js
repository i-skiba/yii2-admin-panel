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

        var elements = document.querySelectorAll('.dnd-grid-view');
        if(null === elements) {
            return;
        }

        var drake = dragula(Array.apply(null, ), {
            // mirrorContainer: document.querySelector('.dnd-grid-view tr'),
        });

        // shows or hide elements with class .hide-on-drag
        var toggleHideOnDragElements = function (el, eventName = 'default') {
            var hideOnDragElems = $(el).parents('.dnd-grid-view').find('.hide-on-drag').parents('td').children();
            if (hideOnDragElems.length !== 0) {
                hideOnDragElems.each(function () {
                    console.log($(this), $(this).hasClass('d-none'), eventName !== 'drag');
                    switch (eventName) {
                        case 'drag':
                            $(this).addClass('d-none');
                            break;
                        case 'cancel':
                        case 'drop':
                            $(this).removeClass('d-none');
                            break;
                    }
                });
            }
        };

        // update input indexes after sort
        var updateIndexes = function (target) {
            var $container = $(target);
            var $elements = $container.find("tr").not( ".gu-mirror" );
            var sort = [];
            $.each($elements, function(index, target) {
                sort[index] = $(this).attr('data-key');

                var inputs = $(this).find(':input');
                if (inputs.length !== 0) {
                    $(inputs).each(function () {
                        if ($(this)[0].hasAttribute("name")) {
                            var changedIndex = $(this).attr('name')
                                .replace(
                                    $(this).attr('name').match(/\[[0-9]+\]/),
                                    '[' + index + ']'
                                );
                            $(this).attr('name', changedIndex);
                        }
                    });
                }
            });
        };

        drake.on('drag', function(el) {
            toggleHideOnDragElements(el, 'drag');
        });

        drake.on('cloned', function(clone, original, type, event) {
            // remove mirror
            $(clone).addClass('d-none');
        });

        drake.on('cancel', function (el, container, source) {
            toggleHideOnDragElements(el, 'cancel');
        });

        drake.on('drop', function (el, target, source, sibling) {
            toggleHideOnDragElements(el, 'drop');
            updateIndexes(target);

            var $container = $(target);
            if($container.attr('data-without-request') !== undefined ) {
                return;
            }

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
