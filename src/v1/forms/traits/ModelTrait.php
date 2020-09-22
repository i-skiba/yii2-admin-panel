<?php

namespace kamaelkz\yii2admin\v1\forms\traits;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use \yii\base\Model;

/**
 * Трейт для моделей и форм
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
trait ModelTrait
{
    /**
     * @var bool
     */
    public $isNewRecord = true;
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
     * Возвращает название формы в формате underscore form_name
     *
     * @return mixed
     */
    public function underscoreFormName()
    {
        return Inflector::underscore($this->formName());
    }


    /**
     * @param null $modelClass
     * @param int $count
     * @return array|mixed|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function createClear($modelClass = null, $count = 1, $data = [])
    {
        $models = [];
        if (! $modelClass) {
            $modelClass = (static::class);
        }

        for($i = 0; $i < $count; $i ++) {
            $instance = Yii::createObject($modelClass);
            if($data) {
                foreach ($data as $attribute => $value) {
                    if (
                        ($instance instanceof ActiveRecord && $instance->hasAttribute($attribute))
                        || ($instance instanceof Model && property_exists($instance, $attribute))
                    ) {
                        $instance->{$attribute} = $value;
                    }
                }
            }

            $models[] = $instance;
        }

        return $models;
    }

    /**
     * Создание моделей из массива
     *
     * @param null $modelClass
     * @param array $array
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function createFromArray($modelClass = null, $array = [])
    {
        $models = [];
        if(! $modelClass) {
            $modelClass = (static::class);
        }

        foreach ($array as $item) {
            $instance = Yii::createObject($modelClass);
            if($item instanceof Model) {
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
}