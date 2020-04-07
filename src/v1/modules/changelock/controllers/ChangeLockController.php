<?php

namespace kamaelkz\yii2admin\v1\modules\changelock\controllers;

use Yii;
use kamaelkz\yii2admin\v1\controllers\traits\ControllerTrait;
use concepture\yii2logic\controllers\web\Controller;

/**
 * Контроллер по умолчанияю
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ChangeLockController extends Controller
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
                    'check',
                ],
                'allow' => true,
                'roles' => [
                    '@'
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getService()
    {
        return Yii::$app->adminChangeLockService;
    }
}