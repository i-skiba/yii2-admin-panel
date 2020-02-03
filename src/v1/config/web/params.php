<?php

return [
    'yii2admin-navigation' => [
        'index' => [
            'position' => 1,
            'label' => Yii::t('yii2admin', 'Главная'),
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
            'label' => Yii::t('yii2admin', 'Разработчику'),
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
                    'label' => Yii::t('yii2admin', 'Генератор'),
                    'url' => ['/gii'],
                    'active' => [
                        'rules' => [
                            'm' => ['gii']
                        ],
                    ]
                ],
                [
                    'label' => Yii::t('yii2admin', 'Интерфейс'),
                    'url' => ['/uikit/crud'],
                    'active' => [
                        'rules' => [
                            'mc' => ['uikit', ['crud']]
                        ],
                    ]
                ],
                [
                    'label' => Yii::t('yii2admin', 'Виджеты'),
                    'url' => ['/uikit/widgets'],
                    'active' => [
                        'rules' => [
                            'mc' => ['uikit', ['widgets']]
                        ]
                    ]
                ],
                [
                    'label' => Yii::t('yii2admin', 'Магические модалки'),
                    'url' => ['/uikit/magic-modal'],
//                    'icon' => 'icon-magic-wand2',
                    'active' => [
                        'rules' => [
                            'mc' => ['uikit', ['magic-modal']]
                        ]
                    ]
                ],
            ]
        ],
    ]
];