<?php

use concepture\yii2user\enum\UserRoleEnum;

return [
    'yii2admin-navigation' => [
        'index' => [
            'position' => 1,
            'label' => Yii::t('common', 'Главная'),
            'url' => ['/site/index'],
            'icon' => 'icon-home4',
            'active' => [
                'rules' => [
                    'ca' => ['site', 'index']
                ]
            ],
            'visible' => [
                'sidebar' => function() {
                    return true;
                },
                'dashboard' => false
            ]
        ],
        'uikit' => [
            'position' => 1000,
            'label' => Yii::t('common', 'Разработчику'),
            'url' => ['/uikit'],
            'icon' => 'icon-wrench',
            'color' => 'info',
            'active' => [
                'rules' => [
                    'm' => [['uikit', 'gii']]
                ]
            ],
            'visible' => [
                'sidebar' => YII_DEBUG,
                'dashboard' => YII_DEBUG
            ],
            'children' => [
                [
                    'label' => Yii::t('common', 'Генератор'),
                    'url' => ['/gii'],
                    'ignoreRbac' => true,
                    'active' => [
                        'rules' => [
                            'm' => ['gii']
                        ],
                    ]
                ],
                [
                    'label' => Yii::t('common', 'Интерфейс'),
                    'url' => ['/uikit/crud'],
                    'ignoreRbac' => true,
                    'active' => [
                        'rules' => [
                            'mc' => ['uikit', ['crud']]
                        ],
                    ]
                ],
                [
                    'label' => Yii::t('common', 'Виджеты'),
                    'url' => ['/uikit/widgets'],
                    'ignoreRbac' => true,
                    'active' => [
                        'rules' => [
                            'mc' => ['uikit', ['widgets']]
                        ]
                    ]
                ],
                [
                    'label' => Yii::t('common', 'Магические модалки'),
                    'url' => ['/uikit/magic-modal'],
                    'ignoreRbac' => true,
//                    'icon' => 'icon-magic-wand2',
                    'active' => [
                        'rules' => [
                            'mc' => ['uikit', ['magic-modal']]
                        ]
                    ]
                ],
            ]
        ],
        'audit' => [
            'position' => 1001,
            'label' => Yii::t('common', 'Аудит'),
            'url' => ['/audit/audit/index'],
            'icon' => 'icon-eye',
            'active' => [
                'rules' => [
                    'ca' => ['audit', 'index']
                ]
            ],
            'visible' => [
                'sidebar' => function() {
                    return \kamaelkz\yii2admin\v1\modules\audit\services\AuditService::isVisibleForUser();
                },
                'dashboard' => false
            ]
        ],
    ]
];