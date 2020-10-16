<?php

$config = [
    'aliases' => [
        '@yii2admin' => '@vendor/kamaelkz/yii2-admin-panel/src/v1',
    ],
    'bootstrap' => [
        'kamaelkz\yii2admin\v1\Yii2Admin',
    ],
    'modules' => [
        'audit' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\audit\Module',
            'auditModels' => [
                'concepture\yii2user\models\User',
            ],
        ],
        'hints' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\hints\Module'
        ],
        'changelock' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\changelock\Module'
        ],
        'i18n' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\i18n\Module'
        ],
    ],
    'components' => [
        'urlManager' => [
            'class' => 'kamaelkz\yii2admin\v1\components\UrlManager'
        ],
        'view' => [
            'class' => 'kamaelkz\yii2admin\v1\themes\components\view\View',
            'theme' => [
                'class'=> yii\base\Theme::class,
                'basePath'=>'@yii2admin/themes'
            ],
            'definition' => [],
            'customBundles' => [
                'kamaelkz\yii2admin\v1\themes\bundles\ImagesBundle',
                'kamaelkz\yii2admin\v1\themes\bundles\StylesBundle',
                'kamaelkz\yii2admin\v1\themes\bundles\ScriptsBundle',
            ],
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                    ],
                    'functions' => array(
                        '_' => 'Yii::t',
                    ),
                ],
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
        'adminHintsService' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\hints\services\AdminHintsService',
        ],
        'adminChangeLockService' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\changelock\services\AdminChangeLockService',
        ],
        'crudService' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\uikit\services\CrudService',
        ],
        'auditService' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\audit\services\AuditService',
        ],
        'adminMessageService' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\i18n\services\MessageService',
        ],
        'adminSourceMessageService' => [
            'class' => 'kamaelkz\yii2admin\v1\modules\i18n\services\SourceMessageService',
        ],
    ],
    'controllerMap' => [
        'site' => [
            'class' => 'kamaelkz\yii2admin\v1\controllers\DefaultController',
        ],
    ],
];

if(YII_DEBUG) {
    $config['modules']['uikit'] = [
        'class' => 'kamaelkz\yii2admin\v1\modules\uikit\Module'
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class' => 'concepture\yii2logic\gii\model\Generator',
            ],
        ],
        'allowedIPs' => ['*']
    ];
}

return $config;