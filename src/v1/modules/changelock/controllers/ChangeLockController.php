<?php

namespace kamaelkz\yii2admin\v1\modules\changelock\controllers;

use Yii;
use kamaelkz\yii2admin\v1\controllers\traits\ControllerTrait;
use concepture\yii2logic\controllers\web\Controller;
use yii\web\BadRequestHttpException;

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
                    'update-lock',
                ],
                'allow' => true,
                'roles' => [
                    '@'
                ],
            ],
        ];
    }

    public function actionUpdateLock()
    {
        $url = Yii::$app->request->post('url');
        if (! $url){
            throw new BadRequestHttpException();
        }

        $this->getService()->updateUrl($url);
    }

    public function actionCheck()
    {
        $url = Yii::$app->request->post('url');
        if (! $url){
            throw new BadRequestHttpException();
        }

        $lock = $this->getService()->checkUrl($url);
        if ($lock === true){
            return $this->responseJson([
                'can' => true
            ]);
        }

        return $this->responseJson([
            'can' => false,
            'blocked_by' => Yii::$app->userService->findById($lock->user_id)
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getService()
    {
        return Yii::$app->adminChangeLockService;
    }
}