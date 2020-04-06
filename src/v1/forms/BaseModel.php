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
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model = new $modelClass;
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
}