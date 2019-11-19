<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\pickers;

use Yii;
use kamaelkz\yii2admin\v1\widgets\base\BaseBundle;

/**
 * Ресурсы для виджета
 * 
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class Bundle extends BaseBundle
{
    public $js = [
        'js/picker.js',
        'js/picker.date.js',
        'js/picker.time.js',
        'js/legacy.js',
    ];

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $language = Yii::$app->getFormatter()->language;
        $iso = str_replace('-', '_', $language);
        $this->js[] = "js/translations/{$iso}.js";
    }
}