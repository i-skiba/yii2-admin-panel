<?php

namespace kamaelkz\yii2admin\v1\modules\audit\actions;

use concepture\yii2logic\helpers\StringHelper;
use ReflectionException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use concepture\yii2logic\actions\Action;
use concepture\yii2logic\services\Service;
use kamaelkz\yii2admin\v1\modules\audit\models\Audit;
use kamaelkz\yii2admin\v1\modules\audit\services\AuditService;
use concepture\yii2logic\services\events\modify\AfterUpdateEvent;

/**
 * Class AuditRollbackAction
 * @package backend\modules\audit\actions
 */
class AuditRollbackAction extends Action
{
    /**
     * @return string
     */
    public static function actionName()
    {
        return 'audit-rollback';
    }

    /**
     * @return AuditService
     */
    private function getAuditService()
    {
        return \Yii::$app->auditService;
    }

    /**
     * TODO return ?
     * @param integer $id
     * @param integer $model_pk
     * @throws NotFoundHttpException
     * @throws ReflectionException
     */
    public function run($id, $model_pk, $modelClass)
    {
        $service = $this->getService();
        if ($service instanceof AuditService) {
            $service = $service->getModelService($modelClass);
        }
        $originModel = $this->getModel($model_pk, $service);
        if (!$originModel) {
            throw new NotFoundHttpException();
        }

        if ($originModel->validate()) {
            $audit = $this->getAuditService()->findById($id);
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