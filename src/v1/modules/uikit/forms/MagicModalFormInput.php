<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\forms;

use Yii;
use kamaelkz\yii2admin\v1\forms\BaseModel;

/**
 * Форма
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class MagicModalFormInput extends BaseModel
{
    public $text_input;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
                    [
                        [
                            'text_input',
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
            'text_input' => Yii::t('yii2admin', 'Текстовое поле'),
        ];
    }
}