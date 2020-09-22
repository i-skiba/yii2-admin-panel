<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m200828_095904_changelock
 */
class m200828_095904_changelock extends Migration
{

    public function getTableName()
    {
        return 'yii2_admin_change_lock';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createColumn('last_access', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200828_095904_changelock cannot be reverted.\n";

        return false;
    }
}
