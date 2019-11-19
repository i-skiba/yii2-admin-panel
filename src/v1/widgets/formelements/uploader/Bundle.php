<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\uploader;

use \yii\web\View;
use kamaelkz\yii2admin\v1\widgets\base\BaseBundle;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Bundle extends BaseBundle
{
    public $js = [
        'js/jquery.ui.widget.js',
        'js/jquery.fileupload.js',
        'js/script.js',
    ];

    public $publishOptions = [
        'forceCopy'=> YII_DEBUG  ? true : false,
        'except' => [
            'server/*',
            'test'
        ],
    ];
}
