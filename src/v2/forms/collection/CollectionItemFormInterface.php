<?php

namespace kamaelkz\yii2admin\v2\forms\collection;

/**
 * Интерфейс элемента формы коллекции
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
interface CollectionItemFormInterface
{
    /**
     * @return boolean
     */
    public function getIsEmpty();

    /**
     * @param boolean $value
     */
    public function setIsEmpty(bool $value);
}