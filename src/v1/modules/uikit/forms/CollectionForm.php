<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\forms;

use Yii;
use concepture\yii2logic\validators\ModelValidator;
use kamaelkz\yii2cdnuploader\pojo\CdnImagePojo;

/**
 * Форма коллекции
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CollectionForm extends \kamaelkz\yii2admin\v1\forms\BaseModel
{
    public $text_input;
    public $dropdown;
    public $image;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [
                [
                    'image',
                    'text_input',
                    'dropdown',
                ],
                'required',
            ],
            [
                [
                    'text_input',
                ],
                'string',
                'max' => 50
            ],
            [
                [
                    'dropdown'
                ],
                'integer'
            ],
            [
                [
                    'image',
                    'image_local'
                ],
                ModelValidator::class,
                'modelClass' => CdnImagePojo::class,
                'modifySource' => false,
                'message' => Yii::t('yii2admin', 'Некорректный формат данных.')
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'text_input' => Yii::t('yii2admin', 'Текстовое поле'),
            'dropdown' => Yii::t('yii2admin', 'Выпадающее меню'),
            'image' => 'Изображение',
        ];
    }
}