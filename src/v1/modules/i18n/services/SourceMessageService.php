<?php

namespace kamaelkz\yii2admin\v1\modules\i18n\services;

use concepture\yii2logic\services\Service;

/**
 * Сервис для работы с оригиналами переводов
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class SourceMessageService extends Service
{
    /**
     * @var string класс перечисления словарей для переводов
     */
    public $messageCategoryEnumClass = '\concepture\yii2handbook\enum\MessageCategoryEnum';
}