<?php

namespace kamaelkz\yii2admin\v1\modules\changelock\models;

use concepture\yii2logic\models\ActiveRecord;
use Yii;

/**
 * Модель для хранения данных по редактированию сущностей
 *
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class AdminChangeLock extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'yii2_admin_change_lock';
    }

    public function rules()
    {
        return [
            [
                [
                    'user_id',
                ],
                'integer'
            ],
            [
                [
                    'url',
                    'last_acess_date_time',
                    'session_id',
                ],
                'string',
                'max' => 1024
            ],
        ];
    }
}
