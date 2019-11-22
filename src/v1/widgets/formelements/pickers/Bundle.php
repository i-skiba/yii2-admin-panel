<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\pickers;

use Yii;
use concepture\yii2logic\bundles\Bundle as BaseBundle;
use kamaelkz\yii2admin\v1\helpers\LanguageHelper;

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
        $iso = LanguageHelper::getIso(true);
        $this->js[] = "js/translations/{$iso}.js";
    }
}