Подключение :

backend|frontend/config/main.php
```php
    # конфигурация приложения (из коробки return) 
    $config = [
        ...
    ];

    return yii\helpers\ArrayHelper::merge( 
        ...
        kamaelkz\yii2admin\v1\Yii2Admin::getConfiguration(Yii2Admin::WEB),
        $config
        ....
    );
```

console/config/main.php
```php
    # конфигурация приложения (из коробки return)
    $config = [
        ...
    ];

    return yii\helpers\ArrayHelper::merge(
        ...
        kamaelkz\yii2admin\v1\Yii2Admin::getConfiguration(Yii2Admin::CONSOLE),
        $config
        ....
    );
```
..

Check webhook! 7
