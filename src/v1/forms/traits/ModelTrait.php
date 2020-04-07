<?php

namespace kamaelkz\yii2admin\v1\forms\traits;

use yii\helpers\Inflector;

/**
 * Трейт для моделей и форм
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
trait ModelTrait
{
    /**
     * Возвращает название формы в формате underscore form_name
     *
     * @return mixed
     */
    public function underscoreFormName()
    {
        return Inflector::underscore($this->formName());
    }
}