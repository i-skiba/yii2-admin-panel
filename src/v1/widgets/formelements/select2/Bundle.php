<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\select2;

use Yii;
use kamaelkz\yii2admin\v1\helpers\LanguageHelper;
use concepture\yii2logic\bundles\Bundle as BaseBundle;

/**
 * Class Bundle
 *
 * @package kamaelkz\yii2admin\v1\widgets\formelements\select2
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class Bundle extends BaseBundle
{
    /**
     * @var array
     */
    public $js = [
        'js/select2.min.js',
        'js/yii2-admin-select2.js',
    ];

    /**
     * @var array
     */
    public $css = [
        'css/yii2-admin-select2.css',
    ];
}