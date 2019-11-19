<?php

namespace kamaelkz\yii2admin\v1\themes\bundles;

use yii\web\View;

/**
 * Изображения
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ImagesBundle extends BaseBundle
{
    public $sourcePath = '@yii2admin/themes/resources/limitless/global_assets/images';
    
    public $jsOptions = [
        'position' => View::POS_END
    ];
    public $publishOptions = [
        //'forceCopy'=> YII_DEBUG  ? true : false,
    ];
}
