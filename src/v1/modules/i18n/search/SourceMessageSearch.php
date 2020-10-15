<?php

namespace kamaelkz\yii2admin\v1\modules\i18n\search;

use kamaelkz\yii2admin\v1\modules\i18n\models\SourceMessage;
use kamaelkz\yii2admin\v1\modules\i18n\models\Message;

/**
 * Модель поиска по оригиналам переводов
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class SourceMessageSearch extends \concepture\yii2handbook\search\SourceMessageSearch
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return SourceMessage::tableName();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['id' => 'id']);
    }

    /**
     * @return string
     */
    protected function getMessageTableName()
    {
        return Message::tableName();
    }
}