<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Миграции модуля подсказок
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m200331_064051_yii2_admin_hints_module extends Migration
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
        $this->addTable([
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(100)->notNull(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->dateTime()->defaultValue(new \yii\db\Expression("CURRENT_TIMESTAMP")),
            'is_deleted' => $this->smallInteger()->defaultValue(0),
        ]);
        $this->addIndex(['status']);
        $this->addIndex(['is_deleted']);
    }
}
