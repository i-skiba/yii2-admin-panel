<?php

namespace kamaelkz\yii2admin\v1\modules\hints\forms;


/**
 * Форма подсказок
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminHintsForm extends \kamaelkz\yii2admin\v1\forms\BaseForm
{
    public $locale;
    public $name;
    public $caption;
    public $value;

    /**
     * @inheritDoc
     */
    public function formRules()
    {
        return [
            [
                [
                    'name',
                    'caption',
                    'locale',
                ],
                'required'
            ]
        ];
    }
}
