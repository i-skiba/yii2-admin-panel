<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements;

use yii\helpers\ArrayHelper;
use yii\widgets\Pjax as Base;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;

/**
 * Pjax компонента
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class Pjax extends Base
{
    /**
     * селектор по умолчанию
     */
    const DEFAULT_ID = 'list-pjax';

    /**
     * @inheritDoc
     */
    public static function begin($config = [])
    {
        $custom = [
            'id' => (! RequestHelper::isMagicModal() ? self::DEFAULT_ID : null ),
            'scrollTo' => 'false',
            'enablePushState' => false
        ];
        $config = ArrayHelper::merge($custom, $config);
        
        return parent::begin($config);
    }
}