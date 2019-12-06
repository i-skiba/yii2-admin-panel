<?php

namespace kamaelkz\yii2admin\v1\themes\components\view;

use Yii;

/**
 * Вспомогательный класс для работы с меню проекта
 *
 * @todo сырая вещица
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class SidebarHelper
{
    const ACTIVE_CLASS = 'active';
    const ACTIVE_GROUP_CLASS = ' nav-item-expanded nav-item-open';

    /**
     * Проверка активности меню по контроллеру
     *
     * @param string $c
     * @param string $a
     * @return string|null
     */
    public static function c(string $c)
    {
        $state = false;
        $controller = Yii::$app->controller;

        if(($controller->id == $c)) {
            $state = true;
        }

        return $state ? self::ACTIVE_CLASS  : null;
    }

    /**
     * Проверка активности меню по контроллеру и действию
     *
     * @param string $c
     * @param string $a
     * @return string|null
     */
    public static function ca(string $c, string $a)
    {
        $state = false;
        $controller = Yii::$app->controller;
        $action = $controller->action;

        if(
            ($controller->id == $c)
            && ($action->id == $a)
        ) {
            $state = true;
        }

        return $state ? self::ACTIVE_CLASS  : null;
    }

    /**
     * Проверка активности меню по модулю и контроллерам
     *
     * @param string $m
     * @param array $c
     * @return string|null
     */
    public static function mc(string $m, array $c)
    {
        $state = false;
        $controller = Yii::$app->controller;
        $module = $controller->module;

        if(
            ($module && $module->id == $m)
            && (in_array($controller->id, $c))
        ) {
            $state = true;
        }

        return $state ? self::ACTIVE_CLASS  : null;
    }

    /**
     * Проверка активности меню по модулю
     *
     * @param string|array $m
     * @return string|null
     */
    public static function m($m)
    {
        $controller = Yii::$app->controller;
        $module = $controller->module;
        if (
            (is_array($m) && ($module && in_array($module->id, $m)))
            || ($module && $module->id == $m)
        ){
            $state = true;
        }

        return $state ? self::ACTIVE_GROUP_CLASS  : null;
    }

    /**
     * Проверка активности меню по модулю контроллеру и действию
     *
     * @param string $m
     * @param array $c
     * @param string $a
     * @return string|null
     */
    public static function mca(string $m, array $c, string $a)
    {
        $state = false;
        $controller = Yii::$app->controller;
        $action = $controller->action;
        $module = $controller->module;

        if(
            ($module && $module->id == $m)
            && (in_array($controller->id, $c))
            && ($action->id == $a)
        ) {
            $state = true;
        }

        return $state ? self::ACTIVE_CLASS  : null;
    }
}
