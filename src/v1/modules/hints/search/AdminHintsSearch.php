<?php

namespace kamaelkz\yii2admin\v1\modules\hints\search;

use yii\db\ActiveQuery;
use kamaelkz\yii2admin\v1\modules\hints\models\AdminHints;

/**
 * Модель поиска по подсказкам
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminHintsSearch extends AdminHints
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'status',
                    'is_deleted',
                ],
                'integer'
            ],
            [
                [
                    'name',
                ],
                'string'
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function extendQuery(ActiveQuery $query)
    {
        $query->andFilterWhere([
            'id' => $this->id
        ]);
        $query->andFilterWhere([
            'like',
            'name',
            $this->name
        ]);
        $query->andFilterWhere([
            'status' => $this->status
        ]);
        $query->andFilterWhere([
            'is_deleted' => $this->is_deleted
        ]);
    }
}
