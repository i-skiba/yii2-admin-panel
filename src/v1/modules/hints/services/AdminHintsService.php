<?php

namespace kamaelkz\yii2admin\v1\modules\hints\services;

use concepture\yii2logic\forms\Model;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2handbook\services\traits\ModifySupportTrait as HandbookModifySupportTrait;
use concepture\yii2handbook\services\traits\ReadSupportTrait as HandbookReadSupportTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;

/**
 * Сервис для работы с подсказками
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminHintsService extends \concepture\yii2logic\services\Service
{
    use StatusTrait;
    use HandbookModifySupportTrait;
    use HandbookReadSupportTrait;
    use LocalizedReadTrait;

    /**
     * @inheritDoc
     */
    public function beforeModelSave(Model $form, ActiveRecord $model, $is_new_record)
    {
        $form->name = strtoupper($form->name);
        parent::beforeModelSave($form, $model, $is_new_record);
    }
}
