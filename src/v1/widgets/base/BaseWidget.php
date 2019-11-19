<?php

namespace kamaelkz\yii2admin\v1\widgets\base;

use yii\base\Widget;
use concepture\yii2logic\traits\WidgetTrait;

/**
 * Базовый виджет
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseWidget extends Widget
{
    use WidgetTrait;

    /**
     * @inheritDoc
     */
    public function beforeRun()
    {
        $this->registerBundle();

        return parent::beforeRun();
    }
}