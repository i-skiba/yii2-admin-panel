<?php
use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m201113_053710_audit_modify_character_set
 */
class m201113_053710_audit_modify_character_set extends Migration
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return 'audit';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "
            ALTER TABLE {$this->getTableName()} 
                MODIFY COLUMN old_value TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                MODIFY COLUMN new_value TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ";
        $this->execute($sql);
    }
}
