<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\forms;

use Yii;
use kamaelkz\yii2admin\v1\forms\BaseModel;

/**
 * Форма для UIkit
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class MagicModalForm extends BaseModel
{
    public $image;
    public $text_input;
    public $text_area;
    public $checkbox_standart;

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
                            'text_area',
                            'checkbox_standart',
                        ],
                        'required',
                    ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'image' => 'Изображение',
            'text_input' => Yii::t('yii2admin', 'Текстовое поле'),
            'text_area' => Yii::t('yii2admin', 'Многострочное текстовое поле'),
            'checkbox_standart' => Yii::t('yii2admin', 'Чекбокс стандартный'),
        ];
    }
}