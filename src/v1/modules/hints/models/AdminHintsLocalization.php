<?php

namespace kamaelkz\yii2admin\v1\modules\hints\models;

use concepture\yii2logic\models\ActiveRecord;

/**
 * Модель локальзованных подсказок
 *
 * @property integer $entity_id
 * @property integer $locale
 * @property string $caption
 * @property string $value
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminHintsLocalization extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'yii2_admin_hints_localization';
    }
}
