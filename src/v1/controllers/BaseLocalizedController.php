<?php

namespace kamaelkz\yii2admin\v1\controllers;

use concepture\yii2logic\controllers\web\localized\Controller;
use kamaelkz\yii2admin\v1\controllers\traits\ControllerTrait;

/**
 * Базовы контроллер административной части приложения
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseLocalizedController extends Controller
{
    use ControllerTrait;
}