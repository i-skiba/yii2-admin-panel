<?php

namespace kamaelkz\yii2admin\v1\modules\hints\controllers;

use kamaelkz\yii2admin\v1\controllers\BaseController;
use Yii;
use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2logic\enum\AccessEnum;
use yii\helpers\ArrayHelper;

/**
 * Контроллер по умолчанияю
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class HintsController extends BaseController
{
    /**
     * @inheritDoc
     */
    protected function getAccessRules()
    {
        return ArrayHelper::merge(
            parent::getAccessRules(),
            [
                [
                    'actions' => [
                        'create',
                    ],
                    'allow' => true,
                    'roles' => [
                        AccessEnum::SUPERADMIN,
                    ],
                ]
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getService()
    {
        return Yii::$app->adminHintsService;
    }
}