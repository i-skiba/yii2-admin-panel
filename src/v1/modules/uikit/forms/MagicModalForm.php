<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\forms;


use Yii;
use kamaelkz\yii2admin\v1\forms\BaseForm;

/**
 * Форма для UIkit
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class MagicModalForm extends BaseForm
{
    public $image;
    public $text_input;
    public $text_area;
    public $editor;
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
                            'editor',
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
            'editor' => Yii::t('yii2admin', 'Редактор'),
            'checkbox_standart' => Yii::t('yii2admin', 'Чекбокс стандартный'),
        ];
    }
}