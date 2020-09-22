<?php

namespace kamaelkz\yii2admin\v1\validators;

use Yii;
use yii\validators\Validator;
use concepture\yii2logic\forms\Model;

/**
 * Валидатор коллекций моделей
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CollectionModelsValidator extends Validator
{
    /**
     * @var string
     */
    public $requestParam;

    /**
     * @var string
     */
    public $modelClass;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function validateAttribute($model, $attribute)
    {
        if(! $this->requestParam) {
            $instance = Yii::createObject($this->modelClass);
            $this->requestParam = $instance->formName();
        }

        $result = Model::validateMultiple($model->{$attribute});
        if(! $result) {
            if(! $this->message) {
                $this->message = Yii::t('common', 'Некорректный формат данных «{attribute}»', ['attribute' => $model->getAttributeLabel($attribute)]);
            }

            $this->addError($model, $attribute,  $this->message);
        }
    }
}