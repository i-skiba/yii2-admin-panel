<?php

namespace kamaelkz\yii2admin\v1\forms;

use kamaelkz\yii2admin\v1\validators\CollectionModelsValidator;
use Yii;
use yii\validators\Validator;
use yii\web\Application;
use kamaelkz\yii2admin\v1\forms\traits\ModelTrait;
use concepture\yii2logic\forms\Form;

/**
 * Базовая форма
 *
 * @todo: обобщить BaseForm и BaseModel
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseForm extends Form
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
     * Параметр для валидации одного поля
     * Используется в ActiveForm
     *
     * @var string
     */
    public static $validateAttributeParam = 'validate-attribute';

    /**
     * @inheritDoc
     */
    public function validate($attributeNames = null, $clearErrors = true , $model = null)
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

        if(
            Yii::$app instanceof Application
            && (
                ( $attribute = Yii::$app->request->post(static::$validateAttributeParam) )
                || ( $attribute = Yii::$app->request->get(static::$validateAttributeParam) )
            )
            && property_exists($this, $attribute)
        ) {
            parent::validate($attribute, true);

            return false;
        }
        
        return parent::validate($attributeNames, $clearErrors, $model);
    }

    /**
     * @inheritDoc
     */
    public function load($data, $formName = null)
    {
        $parent = parent::load($data, $formName);
        $collectionForms = $this->collectionForms();
        if(! $collectionForms) {
            return $parent;
        }

        foreach ($collectionForms as $attribute => $className) {
            $instance = Yii::createObject($className);
            self::loadMultiple($this->{$attribute}, Yii::$app->getRequest()->post($instance->formName()), '');
            $validator = Validator::createValidator(
                CollectionModelsValidator::class,
                $this,
                $attribute,
                [
                    'modelClass' => $className
                ]
            );
            $this->getValidators()->append($validator);
        }

        return $parent;
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
                $instance->setAttributes($item->attributes, false);
                if (method_exists($instance, 'customizeForm')) {
                    $instance->customizeForm($item);
                }
            } else {
                $instance->setAttributes($item, false);
            }

            $models[] = $instance;
        }

        return $models;
    }

    /**
     * @return array
     */
    protected function collectionForms()
    {
        return [];
    }
}