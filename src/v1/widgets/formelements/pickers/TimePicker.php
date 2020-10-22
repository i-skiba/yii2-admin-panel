<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\pickers;

use kamaelkz\yii2admin\v1\widgets\formelements\pickers\base\PickerWidget;

/**
 * Виджет выбора времени
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class TimePicker extends PickerWidget
{
    /**
     * @inheritDoc
     */
    public function pluginName() 
    {
        return 'pickatime';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultClientOptions()
    {
        return [
            'format' => 'HH:i',
            'formatSubmit' => 'HH:i',
            // Выключаем сабмит с интервалом
            'hiddenName' => false,
            'hiddenPrefix' => 'submit_without_range',
//            'clear' => Yii::t('frontend.common', "Очистить"),
            'interval' => 15
        ];
    }
}
