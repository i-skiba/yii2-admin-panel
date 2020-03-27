<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\activeform;

use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use concepture\yii2logic\widgets\WidgetTrait;
use kamaelkz\yii2admin\v1\forms\BaseForm;

/**
 * Виджет формы
 * Для перезагрузки формы без валидации на элемент вешается
 * класс class="active-form-refresh-control"
 * Работает на событие change
 * 
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    use WidgetTrait;

    const EVENT_BEFORE_RENDER = 'beforeRender';

    const EVENT_AFTER_RENDER = 'afterRender';

    /**
     * @var Model
     */
    public $model;

    /**
     * @var bool
     */
    public $enableClientValidation = false;

    /**
     * @var array
     */
    public $fieldConfig = [
        'options' => [
            'class' => 'form-group'
        ],
        'errorOptions' => [
        '   class' => 'text-danger form-text'
        ],
        'inputOptions' => [
            'class' => 'form-control',
        ],
    ];

    private $defaultOptions = [
        'validateOnSubmit' => true,
        'class' => 'form-vertical'
    ];

    /**
     * @inheritDoc
     */
    public function run()
    {
        $this->options = ArrayHelper::merge($this->defaultOptions, $this->options);
        $content = ob_get_clean();
        echo Html::beginForm($this->action, $this->method, $this->options);
        echo Html::hiddenInput(BaseForm::$refreshParam, null, ['class' => 'active-form-refresh-value']);
        echo Html::hiddenInput(BaseForm::$validateAttributeParam, null, ['class' => 'active-form-validate-attribute']);

        echo $this->beforeRender();
        echo $content;
        echo $this->afterRender();

        if ($this->enableClientScript) {
            $this->registerBundle();
            $this->registerClientScript();
        }

        echo Html::endForm();
    }

    /**
     * Событие до отрисовки контента формы
     */
    private function beforeRender()
    {
        $event = new ActiveFormEvent();
        $event->model = $this->model;

        return $this->trigger(static::EVENT_BEFORE_RENDER, $event);
    }

    /**
     * Событие после отрисовки контента формы
     */
    private function afterRender()
    {
        $event = new ActiveFormEvent();
        $event->model = $this->model;

        return $this->trigger(static::EVENT_AFTER_RENDER, $event);
    }
}