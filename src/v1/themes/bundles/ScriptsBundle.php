<?php

namespace kamaelkz\yii2admin\v1\themes\bundles;

use concepture\yii2logic\bundles\Bundle;
use kamaelkz\yii2admin\v1\helpers\LanguageHelper;
use Yii;

/**
 * Скрипты
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ScriptsBundle extends Bundle
{
    public $sourcePath = '@yii2admin/themes/resources';

    public function init()
    {
        parent::init();
        $iso = LanguageHelper::getIso();
        $this->js = [
            'limitless/global_assets/js/plugins/loaders/pace.min.js',
            'limitless/global_assets/js/plugins/loaders/blockui.min.js',
            'limitless/global_assets/js/main/bootstrap.bundle.min.js',
            'limitless/global_assets/js/plugins/forms/styling/uniform.min.js',
            'limitless/global_assets/js/plugins/forms/styling/switchery.min.js',
            'limitless/global_assets/js/plugins/forms/styling/switch.min.js',
            'limitless/global_assets/js/plugins/notifications/pnotify.min.js',
            'limitless/global_assets/js/plugins/notifications/sweet_alert.min.js',
            'limitless/assets/js/app.js',
            'scripts/yii2admin/notify.js',
            'scripts/yii2admin/checkboxes.js',
            'scripts/yii2admin/selects.js',
            'scripts/yii2admin/core/helpers/lodash.js',
            'scripts/yii2admin/core/app.js',
            "scripts/yii2admin/core/i18n/{$iso}.js",
//            'core/libraries/jquery_ui/core.min.js',
//            'core/libraries/jquery_ui/interactions.min.js',
//            'plugins/forms/selects/select2.min.js',
//            'plugins/forms/styling/uniform.' . Yii::$app->language . '.min.js',
//            'plugins/forms/styling/switchery.min.js',
//            'plugins/forms/styling/switch.min.js',
//            'plugins/forms/selects/selectboxit.min.js',
//            'plugins/notifications/sweet_alert.min.js',
//            'plugins/notifications/pnotify.min.js',
//            'plugins/media/fancybox.min.js',
//            'fancybox.js',
//
//            'core/app.js',
//
//            'pages/form_selectbox.js',
//            'pages/form_layouts.js',
//            'pages/form_inputs.js',
//            'pages/form_select2.js',
//            'pages/form_checkboxes_radios.js',
//            'system.js',
        ];
    }

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
