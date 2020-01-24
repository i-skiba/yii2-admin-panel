<?php

use concepture\yii2logic\console\migrations\Migration;
use concepture\yii2handbook\forms\EntityTypeForm;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m191118_101120_crud_entity extends Migration
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
        $form = new EntityTypeForm();
        $form->table_name = $this->getTableName();
        $form->caption = 'CRUD админка';
        $form->sort_module = 1;

        $result = Yii::$app->entityTypeService->create($form);
        if(! $result) {

            \yii\helpers\VarDumper::dump($form->getErrors());

            throw new \Exception($result);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->getTableName(), 'sort');

        return true;
    }
}
