<?php

namespace kamaelkz\yii2admin\v1\modules\audit\actions;

use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use concepture\yii2logic\actions\Action;
use concepture\yii2handbook\models\DynamicElements;
use kamaelkz\yii2admin\v1\modules\audit\models\Audit;

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
        return 'audit-dynamic-elements';
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
            ->where(['in', 'model_pk', explode(',', $ids)])
            ->andWhere(['model' => DynamicElements::class]);

        $models = $this->getService()->getAllByCondition(function (ActiveQuery $query) use ($ids) {
            $query->andWhere(['in', 'id', explode(',', $ids)]);
            $query->indexBy('id');
        });

        return $this->render('@yii2admin/themes/views/modules/audit/audit', [
            'model' => $this->getController()->getForm(),
            'query' => $query,
            'models' => $models,
        ]);
    }
}