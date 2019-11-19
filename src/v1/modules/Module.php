<?php

namespace kamaelkz\yii2admin\v1\modules;

use Yii;
use concepture\yii2logic\base\Module as CoreModule;
use kamaelkz\yii2admin\v1\themes\components\view\View;

/**
 * Базовый модуль
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class Module extends CoreModule
{
    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $viewInstance = Yii::$app->getView();
        $this->setViewPath($viewInstance->theme->basePath . '/views/modules/' . $this->getUniqueId());
        # установка метки (названия модуля)
        if(
            $viewInstance instanceof View
            && static::getModuleLabel()
        ) {
            $viewInstance->setTitlePrefix(static::getModuleLabel());
        }
    }

    /**
     * Метка (название модуля)
     *
     * @return string|null
     */
    public static function getModuleLabel()
    {
        return null;
    }
}