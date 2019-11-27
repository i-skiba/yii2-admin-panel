<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\controllers;

use kamaelkz\yii2admin\v1\modules\uikit\forms\MagicModalForm;
use kamaelkz\yii2admin\v1\controllers\BaseController;
use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2logic\filters\PjaxFilter;

/**
 * Пример магической модалки
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class MagicModalController extends BaseController
{
    /**
     * @inheritDoc
     */
    protected function getAccessRules()
    {
        return [
            [
                'actions' => [
                    'create',
                ],
                'allow' => true,
                'roles' => [
                    UserRoleEnum::ADMIN
                ],
            ],
        ];
    }
//
//    /**
//     * @inheritDoc
//     */
//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['onlyAjax'] = [
//            'class' => PjaxFilter::class,
//            'except' => ['options'],
//        ];
//
//        return $behaviors;
//    }

    /**
     * @inheritDoc
     */
    public function actions()
    {
        $parent = parent::actions();
        unset($parent['update'], $parent['delete'], $parent['index'], $parent['view']);

        return $parent;
    }

    /**
     * @inheritDoc
     */
    public function getFormClass()
    {
        return MagicModalForm::class;
    }
}