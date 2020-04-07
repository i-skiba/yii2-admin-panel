<?php

namespace kamaelkz\yii2admin\v1\modules\changelock\forms;

use concepture\yii2logic\enum\ScenarioEnum;
use kamaelkz\yii2admin\v1\forms\BaseForm;

/**
 * Форма подсказок
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminChangeLockForm extends BaseForm
{
    public $url;
    public $user_id;
    public $last_acess_date_time;
    public $session_id;

    /**
     * @inheritDoc
     */
    public function formRules()
    {
        return [
            [
                [
                    'url',
                    'user_id',
                    'last_acess_date_time',
                    'session_id',
                ],
                'required'
            ]
        ];
    }
}
