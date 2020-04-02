<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Миграции модуля подсказок
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m200331_064050_yii2_admin_crud_modify extends Migration
{
    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'yii2_admin_crud';
    }

    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $sql = "RENAME TABLE crud TO yii2_admin_crud";
        $this->execute($sql);
    }
}
