<?php

namespace kamaelkz\yii2admin\v1\themes\bundles;

use concepture\yii2logic\bundles\Bundle;

/**
 * Стили
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class StylesBundle extends Bundle
{
    public $sourcePath = '@yii2admin/themes/resources';

    public $css = [
//        'limitless/assets/css/roboto-font.css',
        'limitless/global_assets/css/icons/icomoon/styles.min.css',
        'limitless/global_assets/css/icons/fontawesome/styles.min.css',
//        YII_DEBUG ? 'limitless/assets/css/bootstrap.css' : 'limitless/assets/css/bootstrap.min.css',
        'limitless/assets/css/bootstrap.css',
        YII_DEBUG ? 'limitless/assets/css/bootstrap_limitless.css' : 'limitless/assets/css/bootstrap_limitless.min.css',
        YII_DEBUG ? 'limitless/assets/css/layout.min.css' : 'limitless/assets/css/layout.css',
        YII_DEBUG ? 'limitless/assets/css/components.min.css' : 'limitless/assets/css/components.css',
        YII_DEBUG ? 'limitless/assets/css/colors.min.css' : 'limitless/assets/css/colors.css',
        'styles/yii2admin/custom.css',
    ];
}
