<?php

namespace kamaelkz\yii2admin\v1\modules\hints\models;

use Yii;

/**
 * Модель подсказок
 *
 * @property integer $id
 * @property string $name
 * @property string $caption
 * @property string $value
 * @property integer $status
 * @property string $created_at
 * @property boolean $is_deleted
 * @property integer $type
 * @property integer $domain_id
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminHints extends \concepture\yii2logic\models\ActiveRecord
{
    use \concepture\yii2logic\models\traits\HasLocalizationTrait;
    use \concepture\yii2logic\models\traits\StatusTrait;
    use \concepture\yii2handbook\models\traits\DomainTrait;
    use \concepture\yii2logic\models\traits\IsDeletedTrait;
    use \kamaelkz\yii2cdnuploader\traits\ModelTrait;

    /**
     * @var bool
     */
    public $allow_physical_delete = false;

    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'yii2_admin_hints';
    }

    /**
     * @inheritDoc
     */
    public static function label()
    {
        return Yii::t('yii2admin', 'Подсказки');
    }

    /**
     * @inheritDoc
     */
    public function toString()
    {
        return $this->id;
    }


    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [
                [
                    'status',
                    'locale',
                    'domain_id',
                    'type',
                ],
                'integer'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 100
            ],
            [
                [
                    'caption'
                ],
                'string',
                'max' => 1024
            ],
            [
                [
                    'value'
                ],
                'string',
                'max' => 5096
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [

            'id' => Yii::t('common', '#'),
            'name' => Yii::t('common','Ключ'),
            'value' => Yii::t('common','Значение'),
            'caption' => Yii::t('common','Наименование'),
            'status' => Yii::t('common', 'Состояние'),
            'created_at' => Yii::t('common', 'Дата создания'),
            'is_deleted' => Yii::t('common', 'Удален')
        ];
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->saveLocalizations();

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritDoc
     */
    public function beforeDelete()
    {
        $this->deleteLocalizations();

        return parent::beforeDelete();
    }

    /**
     * @inheritDoc
     */
    public static function getLocaleConverterClass()
    {
        return \concepture\yii2handbook\converters\LocaleConverter::class;
    }
}
