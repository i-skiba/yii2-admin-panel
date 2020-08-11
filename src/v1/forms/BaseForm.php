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
            self::loadMultiple($this->odds, Yii::$app->getRequest()->post($instance->formName()), '');
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
     * @return array
     */
    protected function collectionForms()
    {
        return [];
    }
}