<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Миграции модуля блокировки редактирования
 *
 * @author Olzhas Kulzmabekov <exgamer@live.ru>
 */
class m200331_064054_yii2_admin_edit_lock_module extends Migration
{
    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'yii2_admin_change_lock';
    }

    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $this->addTable([
            'id' => $this->bigPrimaryKey(),
            'url' => $this->string(1024)->notNull(),
            'session_id' => $this->string(1024)->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'last_acess_date_time' => $this->dateTime(),
        ]);

        $this->addUniqueIndex(['url']);
    }
}
