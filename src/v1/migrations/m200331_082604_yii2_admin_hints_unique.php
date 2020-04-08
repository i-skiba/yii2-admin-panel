<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Идентификатор домена
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m200331_082604_yii2_admin_hints_unique extends Migration
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
        $this->dropIndex('uni_name_yii2_admin_hints', $this->getTableName());
        $this->addUniqueIndex(['name', 'domain_id']);
    }
}
