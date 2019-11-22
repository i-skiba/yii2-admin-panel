<?php

namespace frontend\common\components\widgets\magicmodalinput;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\widgets\ActiveForm;

/**
 * Виджет поля ввода для магической модалки
 * 
 * @property Model $model
 * @property string $attribute
 * @property ActiveForm $form
 * @property string $route - роут
 * @property string $callback - js функция обратного вызова
 * @property string $icon - иконка элемента
 * 
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class MagicModalInputWidget extends Widget
{
    public $model;
    public $attribute;
    public $label_attribute;
    public $form;
    public $route;
    public $callback;
    public $icon = 'icon-link';
    public $viewName = 'view';

    public function init()
    {
        parent::init();
        if(! $this->model || (!$this->model instanceof Model)){
            throw new InvalidConfigException('Атрибут {model} не может быть пустым или не является экземпляром класса yii\base\Model');
        }
        if(! $this->attribute){
            throw new InvalidConfigException('Атрибут {attribute} не может быть пустым');
        }
        if(! $this->label_attribute){
            throw new InvalidConfigException('Атрибут {label_attribute} не может быть пустым');
        }
        if(! $this->form || (! $this->form instanceof ActiveForm)){
            throw new InvalidConfigException('Свойство {form} не может быть пустым или не является экземпляром класса yii\widgets\ActiveForm');
        }
        if(! $this->route) {
            throw new InvalidConfigException('Свойство {route} не может быть пустым');
        }
    }

    public function run()
    {
        return $this->render($this->viewName, [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'label_attribute' => $this->label_attribute,
            'form' => $this->form,
            'route' => $this->route,
            'callback' => $this->callback,
            'icon' => $this->icon,
        ]);
    }
}