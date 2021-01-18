<?php

namespace kamaelkz\yii2admin\v2\forms\collection;

use kamaelkz\yii2admin\v2\forms\BaseForm;

/**
 * Форма c коллекциями
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class CollectionAwareForm extends BaseForm implements CollectionAwareFormInterface
{
    use CollectionAwareFormTrait;
}