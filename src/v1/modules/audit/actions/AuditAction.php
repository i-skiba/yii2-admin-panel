<?php

namespace kamaelkz\yii2admin\v1\modules\audit\actions;

use yii\web\NotFoundHttpException;
use concepture\yii2logic\actions\Action;
use kamaelkz\yii2admin\v1\modules\audit\models\Audit;

/**
 * Class AuditAction
 *
 * @package backend\modules\audit\actions
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class AuditAction extends Action
{
    /**
     * @return string
     */
    public static function actionName()
    {
        return 'audit';
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \ReflectionException
     */
    public function run($id)
    {
        $model = $this->getModel($id);
        if (!$model){
            throw new NotFoundHttpException();
        }

        $query = $model->hasMany(Audit::class, ['model_pk' => 'id'])
            ->andOnCondition(['model' => get_class($model)]);

        return $this->render('@yii2admin/themes/views/modules/audit/audit', [
            'originModel' => $model,
            'model' => $this->getController()->getForm(),
            'query' => $query,
        ]);
    }

    /**
     * @param $id
     * @return \yii\db\ActiveRecord
     * @throws \ReflectionException
     */
    protected function getModel($id)
    {
        return $this->getService()->findById($id);
    }
}