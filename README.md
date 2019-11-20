Подключение :

project/config/main.php проекта
```php
    # инициализация компонента
    'bootstrap' => [
        ...
        'kamaelkz\yii2admin\v1\Bootstrap'
        ...
    ],
    # добавление кастомных бандлов
    ...
    'view' => [
        'class' => 'kamaelkz\yii2admin\v1\themes\components\view\View',
        'customBundles' => [
            'project\bundles\CustomBundle'
        ]
    ],
    ...
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
