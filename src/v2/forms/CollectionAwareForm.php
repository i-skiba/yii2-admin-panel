<?php

namespace kamaelkz\yii2admin\v2\forms;

use kamaelkz\yii2admin\v2\forms\traits\CollectionAwareFormTrait;

/**
 * Форма c коллекциями
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class CollectionAwareForm extends BaseForm implements CollectionAwareFormInterface
{
    use CollectionAwareFormTrait;
}