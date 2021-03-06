<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\activeform;

use concepture\yii2logic\bundles\Bundle as BaseBundle;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Bundle extends BaseBundle
{
    public $js = [
        'scripts/yii2-active-form.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
}