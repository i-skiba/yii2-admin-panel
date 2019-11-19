Подключение :

project/config/main.php проекта
```php
    'bootstrap' => [
        ...
        'vendor\kamaelkz\yii2-admin-panel\v1\Bootstrap'
        ...
    ],
```

console/config/main.php
```php
    'controllerMap' => [
        ...
        'migrate-xrayadmin' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@yii2admin/migrations'
            ],
        ],
        ...
    ],
```
