<?php

namespace kamaelkz\yii2admin\v1\modules\audit\controllers;

use Yii;
use kamaelkz\yii2admin\v1\controllers\traits\ControllerTrait;
use concepture\yii2logic\controllers\web\Controller;
use concepture\yii2user\enum\UserRoleEnum;

/**
 * Class AuditController
 * @package kamaelkz\yii2admin\v1\modules\hints\controllers
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class AuditController extends Controller
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
                ],
                'allow' => true,
                'roles' => [
                    UserRoleEnum::SUPER_ADMIN,
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getService()
    {
        return Yii::$app->auditService;
    }
}