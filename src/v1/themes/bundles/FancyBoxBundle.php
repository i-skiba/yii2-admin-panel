<?php

namespace kamaelkz\yii2admin\v1\themes\bundles;

/**
 * Бандл для jquery плагина fancybox
 *
 * @todo пока не юзается
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class FancyBoxBundle extends BaseBundle
{
    public $sourcePath = '@yii2admin/themes/resources/scripts';
    
    public $js = [
        'plugins/media/fancybox.min.js',
        'fancybox.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}