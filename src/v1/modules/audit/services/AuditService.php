<?php

namespace kamaelkz\yii2admin\v1\modules\audit\services;

use yii\helpers\Json;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use concepture\yii2logic\services\Service;
use concepture\yii2logic\helpers\ClassHelper;
use kamaelkz\yii2admin\v1\modules\audit\enum\AuditEnum;
use concepture\yii2handbook\services\traits\ReadSupportTrait;
use concepture\yii2handbook\services\traits\ModifySupportTrait;

/**
 * Class AuditService
 *
 * @package backend\modules\audit\services
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class AuditService extends Service
{
    use ReadSupportTrait;
    use ModifySupportTrait;

    /**
     * @param array $oldAttributes
     * @param array $newAttributes
     * @param string $modelClass
     * @param string $modelPK
     * @param string $action
     * @return bool
     */
    public function auditAttributes($oldAttributes, $newAttributes, $modelClass, $modelPK, $action = 'UNKNOWN')
    {
        if (
            !$oldAttributes
            || !$newAttributes
            || !$modelClass
            || !$modelPK
        ) {
            return false;
        }

        $diff = array_diff_assoc($newAttributes, $oldAttributes);
        if ($diff <= 0) {
            return false;
        }

        $rows = [];
        foreach ($newAttributes as $field => $newValue) {
            $oldValue = isset($oldAttributes[$field]) ? $oldAttributes[$field] : '';

            if ($newValue === null) {
                $newValue = '';
            }

            if ($oldValue === null) {
                $oldValue = '';
            }

            if ($newValue == $oldValue && !in_array($action, [AuditEnum::ACTION_CREATE])) {
                continue;
            }

            $rows[] = [
                'user_id' => \Yii::$app->user->identity->id,
                'action' => $action,
                'model' => $modelClass,
                'model_pk' => $modelPK,
                'field' => $field,
                'old_value' => $oldValue,
                'new_value' => $newValue,
            ];
        }

        if (!$rows) {
            return false;
        }

        return $this->batchInsert(array_keys($rows[0]), $rows);
    }

    /**
     * Аудит модели
     *
     * @param ActiveRecord $model
     * @param string $action - Производимое действие
     * @param array $oldAttributes
     * @return bool
     */
    public function auditModel(ActiveRecord $model, $action, $oldAttributes = [])
    {
        $newAttributes = $model->getAttributes();
        if (!$oldAttributes) {
            $oldAttributes = $model->getOldAttributes();
        }
        $modelClass = $model->className();
        $modelPK = $this->getPrimaryKey($model);
        if ($model->hasAttribute('allow_physical_delete') && $model->allow_physical_delete == false) {
            $action = AuditEnum::ACTION_UPDATE;
        }

        return $this->auditAttributes($oldAttributes, $newAttributes, $modelClass, $modelPK, $action);
    }

    /**
     * @param ActiveRecord $model
     * @param array $oldAttributes
     * @param array $newAttributes
     * @return bool
     * @throws \ReflectionException
     */
    public function auditBatchInsert($model, $oldAttributes, $newAttributes)
    {
        $service = $this->getModelService($model);
        if (!$service) {
            return false;
        }

        foreach ($newAttributes as $pk => $attributes) {
            $modelClass = $service->getRelatedModelClass();
            $this->auditAttributes($oldAttributes[$pk], $attributes, $modelClass, $pk);
        }

        return true;
    }

    /**
     * Подготовка старых и новых аттрибутов перед выполнением batchInsert
     *
     * @param ActiveRecord $model
     * @param array $insertedRows
     * @param array $fields
     * @return array - [массив_старых_значений, массив_новых_значений]
     */
    public function prepareAttributesForBatchInsert($model, $insertedRows, $fields)
    {
        $service = $this->getModelService($model);
        if (!$service) {
            return [[], []];
        }

        $newAttributesForBatch = [];
        $oldAttributesForBatch = [];
        foreach ($insertedRows as $key => $row) {
            $attributes = array_combine($fields, $row);
            $pk = $this->getPrimaryKey($model, $attributes);
            $newAttributesForBatch[$pk] = $attributes;
        }

        $primaryKeys = array_keys($newAttributesForBatch);
        $models = $service->getAllByCondition(function (ActiveQuery $query) use ($model, $primaryKeys) {
            $keys = [];
            foreach ($primaryKeys as $key) {
                $pk = Json::decode($key);
                if (is_array($pk)) {
                    foreach ($pk as $k => $v) {
                        $query->andWhere([$k => $v]);
                    }
                    continue;
                }
                $keys[] = $pk;
            }
            if ($keys) {
                $query->andWhere(['in', $model::getTableSchema()->primaryKey[0], $keys]);
            }
        });

        if (!$models) {
            return [[], []];
        }

        foreach ($models as $model) {
            foreach ($fields as $field) {
                $oldAttributesForBatch[$this->getPrimaryKey($model)][$field] = $model->{$field};
            }
        }

        return [$oldAttributesForBatch, $newAttributesForBatch];
    }

    /**
     * Возвращает первичный ключ, в том числе составной
     * Работает либо по экземплярю AR модели, либо по классу AR модели (нужно передать аттрибуты)
     *
     * @param ActiveRecord $model
     * @param array $attributes
     * @return false|string
     */
    public function getPrimaryKey($model, $attributes = [])
    {
        if (is_string($model) && $attributes) {
            $keys = $model::getTableSchema()->primaryKey;
            if (count($keys) === 1) {
                return isset($attributes[$keys[0]]) ? $attributes[$keys[0]] : null;
            }

            $values = [];
            foreach ($keys as $name) {
                $values[$name] = isset($attributes[$name]) ? $attributes[$name] : null;
            }

            return Json::encode($values);
        }

        $pk = $model->getPrimaryKey();
        return is_array($pk) ? Json::encode($pk) : $pk;
    }

    /**
     * @param ActiveRecord $model
     * @return Service
     */
    public function getModelService($model)
    {
        $serviceName = ClassHelper::getServiceName($model, "");
        return \Yii::$app->{$serviceName};
    }

    /**
     * @return array
     */
    public function getEventsActionMap()
    {
        return [
            Service::EVENT_AFTER_UPDATE => AuditEnum::ACTION_UPDATE,
            Service::EVENT_AFTER_DELETE => AuditEnum::ACTION_DELETE,
        ];
    }

    /**
     * @param $modelClass
     * @return bool
     */
    public static function isAuditAllowed($modelClass)
    {
        $module = \Yii::$app->getModule('audit');
        return $module ? in_array($modelClass, $module->auditModels) : false;
    }
}
