<?php

namespace kamaelkz\yii2admin\v1\modules\changelock\models;

use Yii;
use concepture\yii2logic\models\ActiveRecord;

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
}
