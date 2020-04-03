<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Миграции модуля подсказок
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m200331_064052_yii2_admin_hints_module extends Migration
{
    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'yii2_admin_hints_localization';
    }

    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $this->addTable([
            'entity_id' => $this->bigInteger()->notNull(),
            'locale' => $this->bigInteger()->notNull(),
            'caption' => $this->string(1024),
            'value' => $this->text(),
        ]);
        $this->addPK(['entity_id', 'locale'], true);
        $this->addIndex(['entity_id']);
        $this->addIndex(['locale']);
        $this->addForeign('entity_id', 'yii2_admin_hints','id');
        $this->addForeign('locale', 'locale','id');
    }
}
