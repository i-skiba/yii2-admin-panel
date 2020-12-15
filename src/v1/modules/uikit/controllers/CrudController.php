<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\controllers;

use Yii;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
use kamaelkz\yii2admin\v1\modules\uikit\forms\UikitForm;
use kamaelkz\yii2admin\v1\controllers\BaseController;
use concepture\yii2user\enum\UserRoleEnum;
use kamaelkz\yii2admin\v1\actions\EditableColumnAction;
use kamaelkz\yii2admin\v1\actions\SortAction;
use concepture\yii2handbook\actions\PositionSortIndexAction;
use concepture\yii2handbook\services\EntityTypePositionSortService;

/**
 * Пример CRUD
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CrudController extends BaseController
{
//    /**
//     * @inheritDoc
//     */
//    protected function getAccessRules()
//    {
//        return [
//            [
//                'actions' => [
//                    'index',
//                    'create',
//                    'update',
//                    'view',
////                    'delete',
//                    'notify',
//                    'flash',
//                    'redirect',
//                    'callback',
//                    'sort-crud',
//                    EditableColumnAction::actionName(),
//                    SortAction::actionName(),
//                    PositionSortIndexAction::actionName(),
//                    EditableColumnAction::actionName(),
//                ],
//                'allow' => true,
//                'roles' => [
//                    UserRoleEnum::ADMIN
//                ],
//            ],
//        ];
//    }

    /**
     * @inheritDoc
     */
    public function actions()
    {
        $parent = parent::actions();
        unset($parent['delete']);
        $parent[EditableColumnAction::actionName()] = EditableColumnAction::class;
        $parent['sort-crud'] = SortAction::class;
        $parent[PositionSortIndexAction::actionName()] = [
            'class' => PositionSortIndexAction::class,
            'entityColumns' => [
                'id',
                'text_input',
            ],
            'labelColumn' => 'text_input',
        ];
        $parent[EditableColumnAction::actionName()] = [
            'class' => EditableColumnAction::class,
        ];
        $parent[SortAction::actionName()] = [
            'class' => SortAction::class,
            'serviceClass' => EntityTypePositionSortService::class
        ];

        return $parent;
    }

    public function actionDelete()
    {

    }
    
    public function actionNotify()
    {
        return $this->responseNotify(FlashAlertEnum::ERROR, $this->getErrorFlash());
    }

    public function actionFlash()
    {
        return $this->responseFlash(FlashAlertEnum::ERROR, $this->getErrorFlash());
    }

    public function actionRedirect()
    {
        $this->setSuccessFlash();

        return $this->responseRedirect(['index']);
    }

    public function actionCallback()
    {
        return 'it is callback result';
    }

    /**
     * @inheritDoc
     */
    public function getFormClass()
    {
        return UikitForm::class;
    }
}