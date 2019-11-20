<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\controllers;

use kamaelkz\yii2admin\v1\modules\uikit\forms\UikitForm;
use kamaelkz\yii2admin\v1\controllers\BaseController;
use concepture\yii2user\enum\UserRoleEnum;

/**
 * Пример CRUD
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CrudController extends BaseController
{
    /**
     * @inheritDoc
     */
    protected function getAccessRules()
    {
        return [
            [
                'actions' => [
                    'index',
                    'create',
                    'update',
                    'view'
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
    public function getFormClass()
    {
        return UikitForm::class;
    }
}