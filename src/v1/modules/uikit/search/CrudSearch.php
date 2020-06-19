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
                            'dropdown',
                            'dropdown_root',
                            'dropdown_depend',
                            'dropdown_depend_2',
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
        parent::extendDataProvider($dataProvider);
        $dataProvider->getPagination()->pageSize = 20;
        $dataProvider->getSort()->defaultOrder = ['sort' => SORT_ASC];
    }
}