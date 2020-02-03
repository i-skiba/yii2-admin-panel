<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m191118_101119_crud_sort_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return 'crud';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->getTableName(), 'sort', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->getTableName(), 'sort');

        return true;
    }
}
