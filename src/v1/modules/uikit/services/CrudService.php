<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\services;

use concepture\yii2logic\services\Service;
use concepture\yii2logic\services\traits\UpdateColumnTrait;
use concepture\yii2logic\services\interfaces\UpdateColumnInterface;

/**
 * Сервис для crud
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CrudService extends Service implements UpdateColumnInterface
{
    use UpdateColumnTrait;
}