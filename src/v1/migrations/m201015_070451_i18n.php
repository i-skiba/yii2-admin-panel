<?php

use yii\db\Migration;

/**
 * Class m201015_070451_i18n
 */
class m201015_070451_i18n extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%yii2_admin_source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(),
            'message' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%yii2_admin_message}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_yii2_admin_message_id_language', '{{%yii2_admin_message}}', ['id', 'language']);
        $onUpdateConstraint = 'RESTRICT';
        if ($this->db->driverName === 'sqlsrv') {
            // 'NO ACTION' is equivalent to 'RESTRICT' in MSSQL
            $onUpdateConstraint = 'NO ACTION';
        }
        $this->addForeignKey('fk_yii2_admin_message_source_message', '{{%yii2_admin_message}}', 'id', '{{%yii2_admin_source_message}}', 'id', 'CASCADE', $onUpdateConstraint);
        $this->createIndex('idx_yii2_admin_source_message_category', '{{%yii2_admin_source_message}}', 'category');
        $this->createIndex('idx_yii2_admin_message_language', '{{%yii2_admin_message}}', 'language');
    }
}
