Подключение :

project/config/main.php проекта
```php
    'bootstrap' => [
        ...
        'kamaelkz\yii2admin\v1\Bootstrap'
        ...
    ],
```

console/config/main.php
```php
    'aliases' => [
        ...
        '@yii2admin' => '@vendor/kamaelkz/yii2-admin-panel/src/v1',
        ...
    ],
    'controllerMap' => [
        ...
        'migrate-yii2admin' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@yii2admin/migrations'
            ],
        ],
        ...
    ],
```
