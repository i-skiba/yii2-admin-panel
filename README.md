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
