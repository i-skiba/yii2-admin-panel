$(document).ready(function(){
    $(document).on('click', '.input-add' , function(){
        var box = $(this).closest('.multiinput-box');
        var limit = box.attr('data-limit');
        var elCount = box.find('.multiinput-box-element').length
        if(elCount == limit) {
            return;
        }

        var element = $(this).closest('.multiinput-box-element');
        var originalInput = element.find('input[type="text"]');
        var clone = element.clone();
        clone.find('.input-add').remove();
        clone.find('.input-remove').removeClass('d-none');
        copyInput = clone.find('input[type="text"]');
        copyInput.val("");
        copyInput.attr('name', getNextElementName(originalInput.attr('name'), elCount));
        box.append(clone);
    });

    $(document).on('click', '.input-remove' , function(){
        var box = $(this).closest('.multiinput-box');
        var limit = box.attr('data-limit');
        var element = $(this).closest('.multiinput-box-element');
        element.remove();
    });
    
    /**
     * Возвращает атрибут name для нового элемента
     * происходит инкримент индекса
     * InstitutionForm[phone][0++]
     * 
     * @param string name
     * @returns string
     */
    function getNextElementName(name, count)
    {
        var index = name.split('[').pop().split(']').shift();
        var newindex = count;
        
        return name.replace('[' + index + ']', '[' + newindex + ']');
    }
});