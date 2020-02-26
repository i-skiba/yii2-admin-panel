<?php

namespace kamaelkz\yii2admin\v1\controllers;

use Yii;
use yii\web\Response;
use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2user\forms\EmailPasswordResetRequestForm;
use concepture\yii2user\forms\PasswordResetForm;
use concepture\yii2user\forms\SignInForm;
use concepture\yii2user\forms\SignUpForm;
use concepture\yii2user\traits\ServicesTrait as UserServices;

/**
 * Главный контроллер приложения
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class DefaultController extends BaseController
{
    use UserServices;

    public $defaultAction = 'login';

    /**
     * @inheritDoc
     */
    protected function getAccessRules()
    {
        return [
                    [
                        'actions' => [
                            'login',
                            'logout',
                            'error',
                            'request-password-reset',
                            'reset-password',
                            'registration'
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'index'
                        ],
                        'allow' => true,
                        'roles' => [
                            UserRoleEnum::ADMIN
                        ],
                    ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'kamaelkz\yii2admin\v1\actions\ErrorAction',
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function beforeAction($action)
    {
        $parent = parent::beforeAction($action);
        if(! in_array($action->id, ['index'])) {
            $this->setSingleLayout();
        }

        return $parent;
    }

    /**
     * Главная страница
     *
     * @return string HTML
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {

            return $this->redirect(['/site/login']);
        }

        return $this->render('index');
    }

    /**
     * Авторизация
     *
     * @return string HTML|Response
     * @throws \Exception
     */
    public function actionLogin()
    {
        if (! Yii::$app->user->isGuest) {
            return $this->redirect(['/site/index']);
        }

        $model = new SignInForm();
        $model->setRestrictions([UserRoleEnum::ADMIN]);
        if (
            $model->load(Yii::$app->request->post())
            && $model->validate()
            && ($data = $this->authService()->signIn($model))
        ) {
            if (is_array($data) && isset($data['redirect'])){
                return $this->redirect($data['redirect'], 301);
            }

            return $this->redirect(['/site/index']);
        }

        $model->validation = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Запрос на смену пароля
     *
     * @return string HTML|Response
     * @throws \Exception
     */
    public function actionRequestPasswordReset()
    {
        if (! Yii::$app->user->isGuest) {
            return $this->redirect(['/site/index']);
        }

        $model = new EmailPasswordResetRequestForm();
        $model->route = "/site/reset-password";
        if ($model->load(Yii::$app->request->post()) && $this->authService()->sendPasswordResetEmail($model) ) {
            Yii::$app->session->setFlash('success', Yii::t('yii2admin', "Проверьте почту"));

            return $this->redirect(['/site/login']);
        }

        return $this->render('password_reset_request', [
            'model' => $model,
        ]);
    }

    /**
     * Смена пароля
     *
     * @param string $token
     *
     * @return string HTML|Response
     * @throws \Exception
     */
    public function actionResetPassword($token)
    {
        if (! Yii::$app->user->isGuest) {
            return $this->redirect(['/site/index']);
        }

        $model = new PasswordResetForm();
        $model->token = $token;
        if ($model->load(Yii::$app->request->post()) && $this->authService()->changePassword($model) ) {
            Yii::$app->session->setFlash('success', Yii::t('yii2admin', "Пароль успешно изменен"));

            return $this->redirect(['/site/index']);
        }

        return $this->render('password_reset', [
            'model' => $model,
        ]);
    }

    /**
     * Регистрация
     *
     * @return string HTML|Response
     * @throws \Exception
     */
    public function actionRegistration()
    {
        if (! Yii::$app->user->isGuest) {
            return $this->redirect(['/site/index']);
        }

        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $this->authService()->signUp($model) ) {
            Yii::$app->session->setFlash('success', Yii::t('yii2admin', "Успешная регистрация. Теперь вы можете авторизоваться."));

            return $this->redirect(['/site/index']);
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    /**
     * Выход
     *
     * @return string|Response
     * @throws \Exception
     */
    public function actionLogout()
    {
        $this->authService()->signOut();

        return $this->redirect(['/site/login']);
    }
}