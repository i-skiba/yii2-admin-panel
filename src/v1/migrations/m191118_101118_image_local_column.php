<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m191118_101118_image_local_column extends Migration
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
        $this->addColumn($this->getTableName(), 'image_local', $this->string(1024));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->getTableName(), 'image_local');

        return true;
    }
}
