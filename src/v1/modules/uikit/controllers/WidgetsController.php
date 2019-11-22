<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\controllers;

use kamaelkz\yii2admin\v1\modules\uikit\enum\UiikitEnum;
use Yii;
use kamaelkz\yii2admin\v1\controllers\BaseController;
use kamaelkz\yii2admin\v1\modules\uikit\forms\UikitForm;
use concepture\yii2user\enum\UserRoleEnum;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class WidgetsController extends BaseController
{
    /**
     * @inheritDoc
     */
    protected function getAccessRules()
    {
        return [
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
     * @inheritDoc
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);

        return $actions;
    }

    /**
     * Главная страница
     */
    public function actionIndex()
    {
        $this->setSuccessFlash();
        $this->setErrorFlash();

        $uikitForm = new UikitForm();
        if ($uikitForm->load(Yii::$app->request->post()) && $uikitForm->validate()) {
            dump($uikitForm->getAttributes());
        }

        return $this->render('index', [
            'uikitForm' => $uikitForm,
            'dropdownList' => UiikitEnum::getDropdownList(),
            'checkboxList' => UiikitEnum::getCheckboxList(),
        ]);
    }
}