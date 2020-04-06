<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Миграции уникальный ключ
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m200331_064053_yii2_admin_hints_unique extends Migration
{
    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'yii2_admin_hints';
    }

    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $this->addUniqueIndex(['name']);
    }
}
