<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\search;

use kamaelkz\yii2admin\v1\modules\uikit\models\Crud;
use yii\data\ActiveDataProvider;

/**
 * Модель поиска для crud
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CrudSearch extends Crud
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
                        ],
                        'integer'
                    ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function extendDataProvider(ActiveDataProvider $dataProvider)
    {
        $dataProvider->getPagination()->pageSize = 1;

        parent::extendDataProvider($dataProvider);
    }
}