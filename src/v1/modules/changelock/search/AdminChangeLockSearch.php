<?php

namespace kamaelkz\yii2admin\v1\modules\changelock\search;

use yii\db\ActiveQuery;
use kamaelkz\yii2admin\v1\modules\hints\models\AdminHints;

/**
 * Class AdminChangeLockSearch
 * @package kamaelkz\yii2admin\v1\modules\hints\search
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class AdminChangeLockSearch extends AdminHints
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
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
    }
}
