<?php

namespace kamaelkz\yii2admin\v1\modules\audit\actions;

use yii\web\NotFoundHttpException;
use backend\modules\audit\models\Audit;
use concepture\yii2logic\actions\Action;

/**
 * Class AuditDynamicElementsAction
 *
 * @package backend\modules\audit\actions
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class AuditDynamicElementsAction extends Action
{
    /**
     * @return string
     */
    public static function actionName()
    {
        return 'view';
    }

    /**
     * @param $ids
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \ReflectionException
     */
    public function run($ids)
    {
        $query = Audit::find()
            ->where(['in', 'model_pk', explode(',', $ids)]);

        return $this->render('@yii2admin/themes/views/modules/audit/audit', [
            'model' => $this->getController()->getForm(),
            'query' => $query,
        ]);
    }
}