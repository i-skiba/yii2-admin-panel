<?php

namespace kamaelkz\yii2admin\v1\modules\audit\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use concepture\yii2logic\enum\AccessEnum;
use kamaelkz\yii2admin\v1\controllers\BaseController;

/**
 * Class AuditController
 * @package kamaelkz\yii2admin\v1\modules\hints\controllers
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class AuditController extends BaseController
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
                        'rollback',
                    ],
                    'allow' => true,
                    'roles' => [
                        AccessEnum::SUPERADMIN,
                    ],
                ]
            ]
        );
    }
}