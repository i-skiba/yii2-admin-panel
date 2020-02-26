<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\select2;

use yii\web\View;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
use Symfony\Component\DomCrawler\Crawler;
use concepture\yii2logic\widgets\WidgetTrait;
use Symfony\Component\CssSelector\CssSelector;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;

/**
 * Class Select2
 * 
 * @package kamaelkz\yii2admin\v1\widgets\formelements\select2
 * @author Poletaev Eugene <evgstn7@gmail.com>
 * @see Documentaion https://select2.org/
 */
class Select2 extends InputWidget
{
    use WidgetTrait;

    /** @var ActiveForm */
    public $form;
    /** @var array */
    public $data = [];
    /** @var string */
    public $viewName = 'view';
    /** @var bool */
    public $multiple = false;


    /**
     * Initializes the widget
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if(! $this->form || (! $this->form instanceof ActiveForm)){
            throw new InvalidConfigException(
                'Свойство {form} не может быть пустым или не является экземпляром класса yii\widgets\ActiveForm'
            );
        }
        $this->registerClientScript();
        echo $this->renderSelectHtml();
    }

    /**
     * @param View $view
     */
    protected function registerOptions($view)
    {
        $this->options = array_merge($this->options, [
            'class' => 'select',
            'minimumResultsForSearch' => 'Infinity', // не показывать search
            'minimumResultsForSearch' => 20,
            'width' => 1000,
            'containerCssClass' => 'bg-teal-400',
            'dropdownCssClass' => 'bg-teal-400',
            'minimumInputLength' => 2,
            'maximumInputLength' => 5,
            'allowClear' => true,
            'tags' => true,
            'tokenSeparators' => [",", " "],
            'maximumSelectionLength' => 3,
            'maximumSelectionSize' => 3,
        ]);
        if (isset($this->options['prompt'])) {
            $this->options['data-placeholder'] = $this->options['prompt'];
        }

        $encOptions = $this->options ? Json::encode($this->options) : '';
        $view->registerJs("$('.select').select2({$encOptions});\n", $view::POS_END);
    }

    /**
     * This registers the necessary JavaScript code.
     */
    private function registerClientScript()
    {
        $this->registerBundle();
        $this->registerOptions($this->getView());
    }

    /**
     * @return string
     */
    protected function renderSelectHtml()
    {
        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $this->data, $this->options);
        }
        return Html::dropDownList($this->name, $this->value, $this->data, $this->options);
    }
}