<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m200406_082603_audit_add_domain_id
 *
 * @package backend\modules\audit\migrations
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class m200406_082603_audit_add_domain_id extends Migration
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
        $this->addColumn($this->getTableName(), 'domain_id', $this->bigInteger());
        $this->addForeign('user_id', 'user','id');
        $this->addForeign('domain_id', 'domain','id');
        $this->addIndex(['domain_id']);
    }
}