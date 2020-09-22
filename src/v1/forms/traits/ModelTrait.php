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
     * @param array $data
     * @param mixed $scenario
     * @return array|mixed|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function createClear($modelClass = null, $count = 1, $data = [], $scenario = null)
    {
        $models = [];
        if (! $modelClass) {
            $modelClass = (static::class);
        }

        for($i = 0; $i < $count; $i ++) {
            $instance = Yii::createObject($modelClass);
            if($scenario) {
                $instance->setScenario($scenario);
            }

            static::setCreateData($instance, $data);

            $models[] = $instance;
        }

        return $models;
    }

    /**
     * Создание моделей из массива
     *
     * @param null $modelClass
     * @param array $array
     * @param array $data
     * @param mixed $scenario
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function createFromArray($modelClass = null, $array = [], $data = [], $scenario = null)
    {
        $models = [];
        if(! $modelClass) {
            $modelClass = (static::class);
        }

        foreach ($array as $item) {
            $instance = Yii::createObject($modelClass);
            if($scenario) {
                $instance->setScenario($scenario);
            }

            if($item instanceof Model) {
                $instance->setAttributes($item->attributes, false);
                if (method_exists($instance, 'customizeForm')) {
                    $instance->customizeForm($item);
                }
            } else {
                $instance->setAttributes($item, false);
            }

            static::setCreateData($instance, $data);
            $models[] = $instance;
        }

        return $models;
    }

    /**
     * Установка данных в экземпляр при создании
     *
     * @param Model $instance
     * @param array $data
     */
    private static function setCreateData(Model $instance, $data = [])
    {
        if(! $data) {
            return;
        }

        foreach ($data as $attribute => $value) {
            if (
                ($instance instanceof ActiveRecord && $instance->hasAttribute($attribute))
                || ($instance instanceof Model && property_exists($instance, $attribute))
            ) {
                $instance->{$attribute} = $value;
            }
        }
    }
}