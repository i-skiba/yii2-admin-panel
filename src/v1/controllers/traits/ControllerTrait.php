<?php

namespace kamaelkz\yii2admin\v1\controllers\traits;

use Yii;
use yii\helpers\Html;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
use kamaelkz\yii2admin\v1\forms\BaseForm;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;

/**
 * Трейт для контроллеров административной части
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
trait ControllerTrait
{
    use ResponseTrait;

    /**
     * @inheritDoc
     */
    public function init()
    {
        if(Yii::$app->getRequest()->post(BaseForm::$validateAttributeParam)) {
            $this->layout = false;
        }

        parent::init();
    }

    /**
     * Переопределен для формах в модалке
     *
     * @param array|string $url
     * @param int $statusCode
     *
     * @return string|\yii\web\Response
     *
     * @throws \Exception
     */
    public function redirect($url, $statusCode = 302)
    {
        if(
            ! Yii::$app->request->isPjax
            || ! RequestHelper::isMagicModal()
        ) {
            return parent::redirect($url, $statusCode);
        }

        return $this->responseNotify();
    }

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
        if(
            ! Yii::$app->request->isPjax
            || ! RequestHelper::isMagicModal()
        ) {
            return parent::render($view, $params);
        }

        $title = Html::tag('title', $this->getView()->getTitle());
        $content = $this->renderAjax($view, $params);

        return "{$title}{$content}";
    }

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
    public function getSuccessFlash($message = null)
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
}