<?php

namespace kamaelkz\yii2admin\v1\controllers\traits;

use concepture\yii2user\enum\AccessEnum;
use concepture\yii2user\helpers\AccessHelper;
use Yii;
use yii\base\Action;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Event;
use yii\web\View;
use concepture\yii2user\enum\UserRoleEnum;
use kamaelkz\yii2admin\v1\helpers\AppHelper;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
use kamaelkz\yii2admin\v1\forms\BaseForm;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;
use kamaelkz\yii2admin\v1\modules\audit\actions\AuditAction;
use kamaelkz\yii2admin\v1\modules\audit\actions\AuditRollbackAction;
use kamaelkz\yii2admin\v1\modules\audit\services\AuditService;

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

        $this->registerAuditEvents();

        parent::init();
    }

    /**
     * @return array
     */
    protected function getAccessRules()
    {
        $rules = ArrayHelper::merge(AccessHelper::getDefaultAccessRules($this), parent::getAccessRules());

        return ArrayHelper::merge(
            $rules,
            [
                [
                    'actions' => [
                        AuditAction::actionName(),
                        AuditRollbackAction::actionName(),
                    ],
                    'allow' => true,
                    'roles' => [
                        AccessEnum::SUPERADMIN,
                    ],
                ],
            ]
        );
    }

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();

        return ArrayHelper::merge(
            $actions,
            [
                AuditAction::actionName() => AuditAction::class,
                AuditRollbackAction::actionName() => AuditRollbackAction::class,
            ]
        );
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

    /**
     * Регистрация событий аудита
     */
    protected function registerAuditEvents()
    {
        Event::on(View::class, View::EVENT_BEGIN_BODY, function($event) {
            $modelClass = null;
            $controller = $event->sender->context;
            if(
                isset($controller->action)
                && $controller->action instanceof Action
                && $controller->action->id === 'update'
                && method_exists($controller, 'getService')
                && ($modelClass = $controller->getService()->getRelatedModelClass())
                && AuditService::isAuditAllowed($modelClass)
            ) {

                $id = \Yii::$app->request->get('id');
                $this->getView()->viewHelper()->pushPageHeader(
                    [AuditAction::actionName(), 'id' => $id],
                    \Yii::t('yii2admin', 'Аудит'),
                    'icon-eye'
                );
            }
        });

        return true;
    }
}