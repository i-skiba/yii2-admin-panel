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
            this.uniform();
            if(this.select2 !== null) {
                $elements = initHelper.findElelements(this.select2.selector);
                this.select2.initElements($elements);
            }
        }
    };
})();