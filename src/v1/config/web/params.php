<?php

return [
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
            'visible' => function() {
                return true;
            }
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
];