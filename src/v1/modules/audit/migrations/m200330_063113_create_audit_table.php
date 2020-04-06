<?php

//namespace backend\modules\audit\migrations;

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m200330_063113_create_audit_table
 *
 * @package backend\modules\audit\migrations
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class m200330_063113_create_audit_table extends Migration
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return 'audit';
    }

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addTable([
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'action' => $this->string(256)->notNull(),
            'model' => $this->string(256)->notNull(),
            'model_pk' => $this->string(256)->notNull(),
            'field' => $this->string(256)->notNull(),
            'old_value' => $this->text(),
            'new_value' => $this->text(),
            'created_at' => $this->dateTime()->defaultValue(new \yii\db\Expression("NOW()")),
        ]);

        $this->addIndex(['user_id']);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable($this->getTableName());
    }
}