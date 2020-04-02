<?php

namespace kamaelkz\yii2admin\v1\modules\hints;

use Yii;
use kamaelkz\yii2admin\v1\modules\Module as BaseModule;

/**
 * Модуль компонентов XRayAdmin
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class Module extends BaseModule
{
    /**
     * @var bool
     */
    protected $global = true;

    /**
     * @var string
     */
    public $defaultRoute = 'hints';

    /**
     * @return string|null
     */
    public static function getModuleLabel()
    {
        return Yii::t('yii2admin', 'Подсказки');
    }
}
