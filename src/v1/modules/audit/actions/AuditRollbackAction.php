<?php

namespace kamaelkz\yii2admin\v1\modules\audit\actions;

use ReflectionException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use concepture\yii2logic\actions\Action;
use concepture\yii2logic\services\Service;
use kamaelkz\yii2admin\v1\modules\audit\models\Audit;
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
        return 'rollback';
    }

    /**
     * TODO return ?
     * @param integer $id
     * @param integer $model_pk
     * @throws NotFoundHttpException
     * @throws ReflectionException
     */
    public function run($id, $model_pk)
    {
        $originModel = $this->getModel($model_pk);
        if (!$originModel) {
            throw new NotFoundHttpException();
        }

        $model = $this->getForm();
        $model->setAttributes($originModel->attributes, false);

        if ($model->validate($originModel)) {
            $audit = Audit::find()->where(['id' => $id])->one();
            $originModel->{$audit->field} = $audit->old_value;
            $result = $originModel->save();
            if ($result) {
                $this->getService()->trigger(
                    Service::EVENT_AFTER_UPDATE,
                    new AfterUpdateEvent(['form' => $model, 'model' => $originModel])
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
    protected function getModel($id)
    {
        return $this->getService()->findById($id);
    }
}