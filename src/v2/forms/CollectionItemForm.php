<?php

namespace kamaelkz\yii2admin\v2\forms;

use kamaelkz\yii2admin\v1\forms\BaseModel;

/**
 * Класс элемента формы коллекции
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class CollectionItemForm extends BaseModel implements CollectionItemFormInterface
{
    /**
     * @var bool признак пустого объекта (нужен для динамик форм)
     */
    private $isEmpty = false;

    /**
     * @return bool
     */
    public function getIsEmpty()
    {
        return $this->isEmpty;
    }

    /**
     * @param boolean $value
     */
    public function setIsEmpty(bool $value)
    {
        $this->isEmpty = $value;
    }
}