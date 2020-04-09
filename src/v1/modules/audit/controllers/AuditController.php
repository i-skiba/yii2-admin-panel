<?php

namespace kamaelkz\yii2admin\v1\modules\audit\controllers;

use concepture\yii2logic\helpers\StringHelper;
use concepture\yii2logic\services\events\modify\AfterUpdateEvent;
use concepture\yii2logic\services\Service;
use kamaelkz\yii2admin\v1\modules\audit\actions\AuditRollbackAction;
use Yii;
use kamaelkz\yii2admin\v1\controllers\traits\ControllerTrait;
use concepture\yii2logic\controllers\web\Controller;
use concepture\yii2user\enum\UserRoleEnum;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

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
                    'rollback',
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

    /**
     * TODO return ?
     * @param integer $id
     * @param integer $model_pk
     * @throws NotFoundHttpException
     * @throws ReflectionException
     */
    public function actionRollback($id, $model_pk, $modelClass)
    {
        $service = $this->getService()->getModelService($modelClass);
        $originModel = $this->getModel($model_pk, $service);
        if (!$originModel) {
            throw new NotFoundHttpException();
        }

        if ($originModel->validate()) {
            $audit = $this->getService()->findById($id);
            $originModel->{$audit->field} = $audit->old_value;
            $result = $originModel->save();
            if ($result) {
                $service->trigger(
                    Service::EVENT_AFTER_UPDATE,
                    new AfterUpdateEvent(['form' => null, 'model' => $originModel])
                );
            }
        }
    }

    /**
     * Возвращает модель для удаления
     *
     * @param $id
     * @return ActiveRecord
     * @throws ReflectionException
     */
    protected function getModel($id, $service)
    {
        if (StringHelper::isJson($id) && is_array(Json::decode($id))) {
            $pk = Json::decode($id);
            return $service->getOneByCondition(function (ActiveQuery $query) use ($pk) {
                foreach ($pk as $key => $value) {
                    $query->andWhere([$key => $value]);
                }
            });
        }
        return $service->findById($id);
    }
}