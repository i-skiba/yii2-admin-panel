<?php

namespace kamaelkz\yii2admin\v1\modules\i18n\models;

/**
 * Оригиналы переводов админка
 *
 * @property int $id
 * @property string $category
 * @property string $message
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class SourceMessage extends \concepture\yii2handbook\models\SourceMessage
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'yii2_admin_source_message';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['id' => 'id']);
    }
}