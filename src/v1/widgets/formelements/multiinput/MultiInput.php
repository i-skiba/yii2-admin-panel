<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\multiinput;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use concepture\yii2logic\widgets\Widget as BaseWidget;

/**
 * Фиджет мультиинупутов добавление / удаление полей
 * 
 * @property Model $model
 * @property string $attribute
 * @property string $viewName - файл представления
 * @property integer $limit - максимальное количество элементов
 * @property string $columnClass - HTML класс элемента
 * @property string $buttonClass - HTML класс кнопки
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class MultiInput extends BaseWidget
{
    /**
     * @var Model
     */
    public $model;

    /**
     * @var string название атрибута
     */
    public $attribute;

    /**
     * @var string название представления
     */
    public $viewName = 'view';

    /**
     * @var string метка
     */
    public $label;

    /**
     * @var int максимальное кол-во элементов
     */
    public $limit = 3;

    /**
     * @var string класс врапер
     */
    public $columnClass = 'col-md-6';

    /**
     * @var string цвет кнопки
     */
    public $buttonClass = 'btn-primary';

    public function init()
    {
        parent::init();
        if(! $this->model || (! $this->model instanceof Model)){
            throw new InvalidConfigException('Атрибут {model} не может быть пустым или не является экземпляром класса yii\base\Model');
        }

        if(! $this->attribute){
            throw new InvalidConfigException('Атрибут {attribute} не может быть пустым');
        }

        if(
            ($this->model instanceof ActiveRecord && ! $this->model->hasAttribute($this->attribute))
            || ($this->model instanceof Model && !property_exists($this->model, $this->attribute))
        ){
            throw new InvalidConfigException('Модель не имеет данного атрибута.');
        }

        if(! $this->label) {
            $this->label = $this->model->getAttributeLabel($this->attribute);
        }
    }

    public function run()
    {
        parent::run();
        $elementCount = 1;
        $value = $this->model->{$this->attribute};
        if( $value && is_array($value)) {
            $elementCount = count($value);
        }
        
        return $this->render('view', [
            'model' => $this->model,
            'attribute' => "{$this->attribute}",
            'label' => $this->label,
            'limit' => $this->limit,
            'elementCount' => $elementCount,
            'columnClass' => $this->columnClass,
            'buttonClass' => $this->buttonClass,
        ]);
    }
}