<?php

namespace kamaelkz\yii2admin\v1\modules\audit\search;

use yii\db\ActiveQuery;
use backend\modules\audit\models\Audit;

/**
 * Class AuditSearch
 *
 * @package common\search
 *
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class AuditSearch extends Audit
{
    /**
     * @return array|void
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'user_id',
                ],
                'integer',
            ],
            [
                [
                    'action',
                    'model',
                    'model_pk',
                    'field',
                    'old_value',
                    'new_value',
                    'created_at',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @param ActiveQuery $query
     */
    public function extendQuery(ActiveQuery $query)
    {
        $query->andFilterWhere([
            static::tableName().'.id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ]);
        $query->andFilterWhere(['like', "action", $this->action]);
        $query->andFilterWhere(['like', "model", $this->model]);
        $query->andFilterWhere(['like', "model_pk", $this->model_pk]);
        $query->andFilterWhere(['like', "field", $this->field]);
    }
}
