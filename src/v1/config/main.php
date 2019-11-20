<?php

return [
    'aliases' => [
        '@yii2admin' => '@vendor/kamaelkz/yii2-admin-panel/src/v1',
    ],
    'modules' => [
        'uikit' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\uikit\Module'
        ],
    ],
    'components' => [
        'view' => [
            'class' => 'kamaelkz\yii2admin\v1\themes\components\view\View',
            'theme' => [
                'class'=> yii\base\Theme::class,
                'basePath'=>'@yii2admin/themes'
            ],
        ],
        'assetManager' => [
            'class' => yii\web\AssetManager::class,
            'linkAssets' => true,
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\web\JqueryAsset' => [
                    'sourcePath' => '@yii2admin/themes/resources',
                    'js' => [
                        'limitless/global_assets/js/main/jquery.min.js'
                    ],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'site' => [
            'class' => 'kamaelkz\yii2admin\v1\controllers\DefaultController',
        ],
    ],
];