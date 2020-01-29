<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\dynamicform;

use concepture\yii2logic\bundles\Bundle as BaseBundle;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Bundle extends BaseBundle
{
    public $js = [
        'scripts/yii2-dynamic-form.js',
    ];

    public $css = [
        'styles/yii2-dynamic-form.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\widgets\ActiveFormAsset'
    ];
}