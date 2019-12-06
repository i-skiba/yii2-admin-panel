<?php

return [
    'yii2admin-navigation' => [
        'index' => [
            'position' => 1,
            'label' => Yii::t('yii2admin', 'Главная'),
            'url' => ['/site/index'],
            'icon' => 'icon-home4',
            'active' => [
                'type' => 'ca',
                'rule' => ['site', 'index']
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
                'type' => 'm',
                'rule' => 'uikit'
            ],
            'visible' => [
                'sidebar' => YII_DEBUG,
                'dashboard' => YII_DEBUG
            ],
            'children' => [
                [
                    'label' => Yii::t('yii2admin', 'Интерфейс'),
                    'url' => ['/uikit/crud'],
                    'active' => [
                        'type' => 'mc',
                        'rule' => ['uikit', ['crud']],
                    ]
                ],
                [
                    'label' => Yii::t('yii2admin', 'Виджеты'),
                    'url' => ['/uikit/widgets'],
                    'active' => [
                        'type' => 'mc',
                        'rule' => ['uikit', ['widgets']]
                    ]
                ],
                [
                    'label' => Yii::t('yii2admin', 'Модальные окна'),
                    'url' => ['/uikit/magic-modal'],
                    'icon' => 'icon-magic-wand2',
                    'active' => [
                        'type' => 'mc',
                        'rule' => ['uikit', ['magic-modal']],
                    ]
                ],
            ]
        ],
    ]
];