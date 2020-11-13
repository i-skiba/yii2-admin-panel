<?php

namespace kamaelkz\yii2admin\v2\forms;

use Yii;
use yii\web\Application;
use kamaelkz\yii2admin\v1\forms\traits\ModelTrait;

/**
 * Базовая форма
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseForm extends \concepture\yii2logic\forms\Form
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
}