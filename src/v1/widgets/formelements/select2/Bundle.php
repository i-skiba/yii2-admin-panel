<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\select2;

use Yii;
use kamaelkz\yii2admin\v1\helpers\LanguageHelper;
use concepture\yii2logic\bundles\Bundle as BaseBundle;

/**
 * Ресурсы для виджета
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class Bundle extends BaseBundle
{
//    public $sourcePath = '@vendor/select2/select2/dist';
//    public $css = [
//        'css/select2',
//    ];

    public $js = [

//        'js/init.js',
        'js/select2.min.js',

    ];

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
//        $iso = LanguageHelper::getIso(true);
//        $this->js[] = "js/translations/{$iso}.js";
    }
}