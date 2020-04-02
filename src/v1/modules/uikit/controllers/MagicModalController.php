<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\controllers;

use Yii;
use kamaelkz\yii2admin\v1\modules\uikit\forms\MagicModalFormInput;
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
                    'index',
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
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['onlyAjax'] = [
            'class' => PjaxFilter::class,
            'except' => ['options', 'index'],
        ];

        return $behaviors;
    }

    /**
     * @inheritDoc
     */
    public function actions()
    {
        $parent = parent::actions();
        unset(
            $parent['index'],
            $parent['view'],
            $parent['update'],
            $parent['delete']
        );

        return $parent;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = Yii::createObject(MagicModalFormInput::class);

        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getFormClass()
    {
        return MagicModalForm::class;
    }
}