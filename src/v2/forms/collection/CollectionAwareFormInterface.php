<?php

namespace kamaelkz\yii2admin\v2\forms\collection;

/**
 * Интерфейс форм с коллекциями
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
interface CollectionAwareFormInterface
{
    /**
     * Массив атрибутов формы
     *
     * [
     *      'foo' => FooForm::class,
     *      'bar' => BarForm::class
     * ]
     *
     * @return array
     */
    public function collectionForms();

    /**
     * @param string $className
     * @param string $attribute
     * @param array $items
     * @return mixed
     */
    public function loadCollections(string $className, string $attribute, array $items);
}