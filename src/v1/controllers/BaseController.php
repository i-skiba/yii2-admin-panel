<?php

namespace kamaelkz\yii2admin\v1\controllers;

use Yii;
use yii\helpers\Html;
use concepture\yii2logic\controllers\web\Controller;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
use kamaelkz\yii2admin\v1\widgets\notifications\alert\FlashAlert;
use kamaelkz\yii2admin\v1\helpers\AppHelper;
use kamaelkz\yii2admin\v1\controllers\traits\ResponseTrait;

/**
 * Базовы контроллер административной части приложения
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseController extends Controller
{
    use ResponseTrait;

//    public function init()
//    {
//        parent::init();
//        $this->setMainLayout();
//    }

    /**
     * Переопределен для формах в модалке
     *
     * @param string $view
     * @param array $params
     *
     * @return string
     */
    public function render($view, $params = []) 
    {
        if(! Yii::$app->request->isPjax) {
            return parent::render($view, $params);
        }

        $title = Html::tag('title', $this->getView()->getTitle());
        $content = $this->renderAjax($view, $params);

        return "{$title}{$content}";
    }

//    /**
//     * Переопределен для формах в модалке
//     *
//     * @param array|string $url
//     * @param int $statusCode
//     *
//     * @return string|\yii\web\Response
//     *
//     * @throws \Exception
//     */
//    public function redirect($url, $statusCode = 302)
//    {
//        if(! Yii::$app->request->isPjax) {
//            return parent::redirect($url, $statusCode);
//        }
//
//        return FlashAlert::widget();
//    }
    
    /**
     * Устанавливает флеш удачной операции в сессию
     *
     * @param string $message
     * @param string|null $title
     */
    public function setSuccessFlash($message = null, string $title = null)
    {
        Yii::$app->session->setFlash(FlashAlertEnum::SUCCESS, $this->getSuccessFlash($message,$title));
    }
    
    /**
     * Устанавливает флешь операции с ошибкой в сессию
     *
     * @param string $message
     */
    public function setErrorFlash($message = null)
    {
        Yii::$app->session->setFlash(FlashAlertEnum::ERROR, $this->getErrorFlash($message));
    }
    
    /**
     * Получает сообщение при успешном выполнении операции
     * 
     * @param string $message
     *
     * @return string
     */
    public function getSuccessFlash($message)
    {
        return empty($message)
                ? Yii::t('yii2admin' , 'Операция прошла успешно.')
                : $message ;
    }

    /**
     * Получает сообщение при неудачном выполнении операции
     *
     * @param string $message
     *
     * @return string
     */
    public function getErrorFlash($message = null)
    {
        return empty($message)
                ? Yii::t('yii2admin' , 'Операция завершилась с ошибкой. Попробуйте позже.')
                : $message;
    }

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