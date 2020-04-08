<?php

namespace kamaelkz\yii2admin\v1\modules\hints\forms;

use concepture\yii2logic\enum\ScenarioEnum;
use kamaelkz\yii2admin\v1\modules\hints\enum\AdminHintsTypeEnum;

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
    public $status;
    public $type = AdminHintsTypeEnum::POPOVER;
    public $domain_id;

    /**
     * @return array|void
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[ScenarioEnum::INSERT] = [
            'name',
            'locale',
            'value',
            'status',
            'type',
            'domain_id'
        ];
        $scenarios[ScenarioEnum::UPDATE] = [
            'name',
            'caption',
            'locale',
            'value'
        ];

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
                    'type',
                ],
                'required'
            ]
        ];
    }
}
