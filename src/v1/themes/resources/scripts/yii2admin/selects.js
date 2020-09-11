var componentSelects = (function() {
    return {
        uniform : function() {
            var selector = '.form-control-uniform';
            var $elements = initHelper.findElelements(selector);

            if($elements === null || $elements.length === 0) {
                return;
            }

            $elements.uniform();
            initHelper.initElements($elements);
        },
        select2: null, // инициализация из виджета \kamaelkz\yii2admin\v1\widgets\formelements\select2\Select2
        initAll : function() {
            if(this.select2 !== null) {
                this.select2.init();
            }
        }
    };
})();