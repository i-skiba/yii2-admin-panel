<?php

namespace kamaelkz\yii2admin\v1\modules\hints\forms;

use concepture\yii2logic\enum\ScenarioEnum;

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
     * @return array|void
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[ScenarioEnum::INSERT] = ['name', 'locale', 'value'];
        $scenarios[ScenarioEnum::UPDATE] = ['name','caption', 'locale', 'value'];

        return $scenarios;
    }

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
