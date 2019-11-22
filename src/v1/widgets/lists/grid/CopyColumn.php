<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use yii\grid\Column;
use yii\helpers\Html;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;

/**
 * Колонка для копирования элементов
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CopyColumn extends Column
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        //$this->registerClientScript();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return  Html::checkBox(RequestHelper::COPY_IDS_PARAM ."[]", false, [
                'value' => $model->id,
                'label' => null,
                'class' => 'switch select-single',
                'data-on-text' => "<i class=' icon-checkmark2'></i>",
                'data-off-text' => "<i class=' icon-cross3'></i>",
                'data-size' => 'mini',
                'data-on-color' => "success",
        ]);
    }
    
    /**
     * Регистрация необходимого скрипта
     * 
     * Вынесен в общий скрипт
     */
    public function registerClientScript()
    {
        $js = <<<JS
            $(document).ready(function() {
                $(document).on('switchChange.bootstrapSwitch', '.select-single', function (e, state) {
                    state == true ? v = state : v = null ;
                    $(this).prop('checked', v);
                    checkedCount = $('.select-single:checked').length;
                    if(checkedCount > 0) {
                        $('.copy-column-controll').removeClass('hidden');
                    } else {
                        $('.copy-column-controll').addClass('hidden');
                    }
                });
                $(document).on('click', '.copy-column-move-controll', function () {
                    var form = $(this).closest('form');
                    form.submit();
                
                    return;
                });
            });    
JS;
        $this->grid->getView()->registerJs($js);
    }
}
