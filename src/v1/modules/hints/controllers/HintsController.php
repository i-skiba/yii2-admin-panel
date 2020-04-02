<?php

namespace kamaelkz\yii2admin\v1\modules\hints\controllers;

use Yii;
use kamaelkz\yii2admin\v1\controllers\traits\ControllerTrait;
use concepture\yii2logic\controllers\web\localized\Controller;
use concepture\yii2user\enum\UserRoleEnum;

/**
 * Контроллер по умолчанияю
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class HintsController extends Controller
{
    use ControllerTrait;

    /**
     * @inheritDoc
     */
    protected function getAccessRules()
    {
        return [
            [
                'actions' => [
                    'index',
                    'view',
//                    'create',
                    'update',
                    'delete',
                    'undelete',
                    'status-change',
                ],
                'allow' => true,
                'roles' => [
                    UserRoleEnum::ADMIN
                ],
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function getService()
    {
        return Yii::$app->adminHintsService;
    }
}