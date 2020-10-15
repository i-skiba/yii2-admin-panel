<?php

namespace kamaelkz\yii2admin\v1\modules\i18n;

use Yii;
use kamaelkz\yii2admin\v1\modules\Module as BaseModule;

/**
 * Модуль разработчику
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
    public $defaultRoute = 'source-message';

    /**
     * @return string|null
     */
    public static function getModuleLabel()
    {
        return Yii::t('yii2admin', 'Переводы');
    }
}