<?php

namespace kamaelkz\yii2admin\v1\controllers;

use Yii;
use yii\helpers\Html;
use concepture\yii2logic\controllers\web\Controller;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
use kamaelkz\yii2admin\v1\widgets\notifications\alert\FlashAlert;
use kamaelkz\yii2admin\v1\helpers\AppHelper;
use kamaelkz\yii2admin\v1\controllers\traits\ControllerTrait;

/**
 * Базовы контроллер административной части приложения
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseController extends Controller
{
    use ControllerTrait;

    /**
     * Установка основного макета
     *
     * @param null $path
     */
    public function setMainLayout($path = null)
    {
        if(null === $path) {
            $this->layout = AppHelper::MAIN_LAYOUT_PATH;

            return;
        }

        $this->layout = $path;
    }

    /**
     * Установка единичного макета
     *
     * @param null $path
     */
    public function setSingleLayout($path = null)
    {
        if(null === $path) {
            $this->layout = AppHelper::SINGLE_LAYOUT_PATH;

            return;
        }

        $this->layout = $path;
    }
}