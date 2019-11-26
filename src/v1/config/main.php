<?php

$config = [
    'aliases' => [
        '@yii2admin' => '@vendor/kamaelkz/yii2-admin-panel/src/v1',
    ],
    'components' => [
        'view' => [
            'class' => 'kamaelkz\yii2admin\v1\themes\components\view\View',
            'theme' => [
                'class'=> yii\base\Theme::class,
                'basePath'=>'@yii2admin/themes'
            ],
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
    ],
    'controllerMap' => [
        'site' => [
            'class' => 'kamaelkz\yii2admin\v1\controllers\DefaultController',
        ],
    ],
    'params' => [
        'yii2admin-sidebar' => [
            'index' => [
                'position' => 1,
                'label' => Yii::t('yii2admin', 'Главная'),
                'url' => ['/site/index'],
                'icon' => 'icon-home4',
                'active' => [
                    'type' => 'ca',
                    'rule' => ['site', 'index']
                ],
            ],
            'uikit' => [
                'position' => 1000,
                'label' => 'UIkit',
                'icon' => 'icon-stack',
                'active' => [
                    'type' => 'm',
                    'rule' => 'uikit'
                ],
                'visible' => YII_DEBUG,
                'children' => [
                    [
                        'label' => Yii::t('yii2admin', 'Виджеты'),
                        'url' => ['/uikit/widgets'],
                        'active' => [
                            'type' => 'mc',
                            'rule' => ['uikit', ['widgets']]
                        ]
                    ],
                    [
                        'label' => Yii::t('yii2admin', 'CRUD'),
                        'url' => ['/uikit/crud'],
                        'active' => [
                            'type' => 'mc',
                            'rule' => ['uikit', ['crud']],
                        ]
                    ],
                ]
            ],
        ]
    ]
];

if(YII_DEBUG) {
    $config['modules']['uikit'] = [
        'class' => 'kamaelkz\yii2admin\v1\modules\uikit\Module'
    ];
}

return $config;