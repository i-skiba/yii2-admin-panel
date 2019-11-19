<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\pickers;

use Yii;
use kamaelkz\yii2admin\v1\widgets\formelements\pickers\base\PickerWidget;

/**
 * Виджет выбора даты
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class DatePicker extends PickerWidget
{
    /**
     * @inheritDoc
     */
    public function pluginName() 
    {
        return 'pickadate';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultClientOptions()
    {
        return [
            'firstDay' => 0,
            'selectMonths' => true,
            'selectYears' => 120,
            'max' => true,
            'format' => 'yyyy-mm-dd',
            'formatSubmit' => 'yyyy-mm-dd',
            'hiddenName' => true,
            'close' => Yii::t(yii2admin, 'закрыть')
        ];
    }
}
