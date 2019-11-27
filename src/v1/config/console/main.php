<?php

return [
    'aliases' => [
        '@yii2admin' => '@vendor/kamaelkz/yii2-admin-panel/src/v1',
    ],
    # TODO автовыполнение
    'controllerMap' => [
        'migrate-yii2admin' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@yii2admin/migrations'
            ],
        ]
    ]
];