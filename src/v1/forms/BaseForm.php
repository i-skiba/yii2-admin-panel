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
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseForm extends Form
{
    use ModelTrait;

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
            $post = Yii::$app->getRequest()->post($instance->formName());
            if(! $post) {
                continue;
            }

            if(! $this->{$attribute}) {
                $this->{$attribute} = $className::createClear(null, count($post));
            }

            self::loadMultiple($this->{$attribute}, $post , '');

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
     * Костыль для динамических форм, добавлен isNewRecord
     *
     * @inheritDoc
     */
    public static function loadMultiple($models, $data, $formName = null)
    {
        if ($formName === null) {
            $first = reset($models);
            if ($first === false) {
                return false;
            }

            $formName = $first->formName();
        }

        $success = false;
        foreach ($models as $i => $model) {
            if ($formName == '') {
                if (!empty($data[$i]) && $model->load($data[$i], '')) {
                    $success = true;
                    if(property_exists($model, 'isNewRecord')) {
                        $model->isNewRecord = false;
                    }
                }
            } elseif (!empty($data[$formName][$i]) && $model->load($data[$formName][$i], '')) {
                $success = true;
                if(property_exists($model, 'isNewRecord')) {
                    $model->isNewRecord = false;
                }
            }
        }

        return $success;
    }

    /**
     * @return array
     */
    protected function collectionForms()
    {
        return [];
    }
}