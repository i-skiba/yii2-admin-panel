<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Идентификатор домена
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m200331_082603_yii2_admin_hints_domain_id extends Migration
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
        $this->addColumn($this->getTableName(), 'type', $this->smallInteger()->defaultValue(0));
        $this->addColumn($this->getTableName(), 'domain_id', $this->integer()->null());
    }
}
