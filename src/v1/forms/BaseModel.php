<?php

namespace kamaelkz\yii2admin\v1\forms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Application;
use concepture\yii2logic\forms\Model;
use kamaelkz\yii2admin\v1\forms\traits\ModelTrait;

/**
 * Базовая форма
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseModel extends Model
{
    use ModelTrait;

    /**
     * Параметр для перезагрузки модели без валидации
     * Используется в ActiveForm
     * 
     * @var string
     */
    public static $refreshParam = 'refresh-form';

    public $isNewRecord = true;

    /**
     * @inheritDoc
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        if(
                Yii::$app instanceof Application
                && (
                    Yii::$app->request->post(static::$refreshParam)
                    || Yii::$app->request->get(static::$refreshParam)
                )
        ) {
            $this->beforeValidate();

            return false;
        }
        
        return parent::validate($attributeNames, $clearErrors);
    }

    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass = null, $multipleModels = [])
    {
        if($modelClass) {
            $model = new $modelClass;
        } else {
            $model = new static();
        }

        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

    /**
     * @param null $modelClass
     * @param int $count
     * @return array|mixed|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function createClear($modelClass = null, $count = 1)
    {
        $models = [];
        if(! $modelClass) {
            $modelClass = (static::class);
        }

        for($i = 0; $i < $count; $i ++) {
            $models[] = Yii::createObject($modelClass);
        }

        return $models;
    }

    public static function createFromArray($modelClass = null, $array = [])
    {
        $models = [];
        if(! $modelClass) {
            $modelClass = (static::class);
        }

        foreach ($array as $item) {
            $instance = Yii::createObject($modelClass);
            if($item instanceof \yii\base\Model) {
                $attributes = $item->attributes;
            }

            $instance->setAttributes($attributes);
            $models[] = $instance;
        }

        return $models;
    }
}