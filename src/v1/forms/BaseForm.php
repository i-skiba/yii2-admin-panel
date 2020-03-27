<?php

namespace kamaelkz\yii2admin\v1\forms;

use Yii;
use concepture\yii2logic\forms\Form;
use yii\web\Application;

/**
 * Базовая форма
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseForm extends Form
{
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
            && $this->hasAttribute($attribute)
        ) {
            parent::validate($attribute, true);

            return false;
        }
        
        return parent::validate($attributeNames, $clearErrors, $model);
    }
}