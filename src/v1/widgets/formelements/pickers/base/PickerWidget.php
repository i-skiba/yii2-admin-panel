<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\pickers\base;

use concepture\yii2logic\widgets\WidgetTrait;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;

/**
 * Базовый виджет пикеров
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class PickerWidget extends InputWidget
{
    use WidgetTrait;

    /**
     * Название query плагина
     *
     * @return string
     */
    abstract function pluginName();

    /**
     * @var array настройки виджета
     */
    public $clientOptions = [];
    
    public function run()
    {
        $this->registerClientScript();

        echo $this->renderInputHtml('text');
    }
    
    /**
     * Инициализация плагина
     */
    private function registerClientScript()
    {
        $view = $this->getView();
        $id = $this->options['id'];
        $clientOptions = Json::htmlEncode(
                ArrayHelper::merge(
                        $this->getDefaultClientOptions(),
                        $this->clientOptions
                )
        );
        $js = 'jQuery("#' . $id . '").' . $this->pluginName() . '(' . $clientOptions. ');';

        $this->registerBundle();
        $view->registerJs($js);
    }
    
    /**
     * Настройки плагина по умолчанию
     * 
     * @return array
     */
    abstract function getDefaultClientOptions();
}
