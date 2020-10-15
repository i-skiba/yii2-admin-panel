<?php

namespace kamaelkz\yii2admin\v1\modules\i18n\models;


/**
 * Переводы по локалям админка
 *
 * @property int $id
 * @property string $language
 * @property string $translation
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Message extends \concepture\yii2handbook\models\Message
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'yii2_admin_message';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceMessage()
    {
        return $this->hasOne(SourceMessage::class, ['id' => 'id']);
    }

}