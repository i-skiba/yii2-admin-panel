<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Таблица для crud операций
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m191118_101117_crud_tables extends Migration
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
        $this->addTable( [
            'id' => $this->bigPrimaryKey(),
            'image' => $this->string(1024)->notNull(),
            'mask' => $this->string(256)->notNull(),
            'text_input' => $this->string(256)->notNull(),
            'text_area' => $this->text()->notNull(),
            'editor' => $this->text()->notNull(),
            'checkbox_standart' => $this->tinyInteger(1)->defaultValue(0),
            'checkbox_switch' => $this->tinyInteger(1)->defaultValue(0),
            'date_picker' => $this->date(),
            'time_picker' => $this->time(),
            'dropdown' => $this->bigInteger(20),
            'dropdown_root' => $this->bigInteger(20),
            'dropdown_depend' => $this->bigInteger(20),
            'dropdown_depend_2' => $this->bigInteger(20),
            'radio' => $this->tinyInteger(1)->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->getTableName());

        return true;
    }
}
