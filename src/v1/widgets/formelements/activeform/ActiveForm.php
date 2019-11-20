<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\activeform;

use yii\helpers\Html;
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

    public $options = [
        'validateOnSubmit' => true,
        'class' => 'form-vertical'
    ];

    /**
     * @inheritDoc
     */
    public function run()
    {
        $content = ob_get_clean();
        echo Html::beginForm($this->action, $this->method, $this->options);
        echo Html::hiddenInput(BaseForm::$refreshParam, null, ['class' => 'active-form-refresh-value']);
        # TODO потом
//        echo $this->errorSummary($this->model);

        echo $content;

        if ($this->enableClientScript) {
            $this->registerBundle();
            $this->registerClientScript();
        }

        echo Html::endForm();
    }
//
//    /**
//     * @inheritDoc
//     */
//    public function errorSummary($models, $options = array())
//    {
//        if(! $models->hasErrors()) {
//            return;
//        }
//
//        return Alert::widget([
//            'message' => parent::errorSummary($models),
//            'type' => FlashAlertEnum::ERROR,
//        ]);
//    }
}