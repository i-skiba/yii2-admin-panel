<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\select2;

use Yii;
use yii\web\JsExpression;
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
 * $form->field($model, 'currency_code')->widget(Select2::class, [
 *     'form' => $form,
 *     'data' => $data,
 *     'options' => [
 *         'multiple' => true,
 *         'prompt' => 'Select something...'
 *      ],
 * ]);
 *
 * Options:
 * @see Documentaion https://select2.org/
 * ================================================================
 * Options examples:
 * 'minimumResultsForSearch' => 'Infinity', // не показывать search
 * 'minimumResultsForSearch' => 20,
 * 'width' => 1000, // Фиксированная ширина
 * 'containerCssClass' => 'bg-teal-400', // Класс контейнера селекта
 * 'dropdownCssClass' => 'bg-teal-400', // Класс выпадающего меню
 * 'minimumInputLength' => 2, // Сколько символов минимум нужно ввести для начала поиска
 * 'maximumInputLength' => 5, // Максимальное количество вводимых символов в поиск
 * 'allowClear' => true, // Добавляет крестик для очистки инпута
 * 'tags' => true, // Tagging support Select2 can be used to quickly set up fields used for tagging. When tagging is
 *                 // enabled the user can select from pre-existing tags or create a new tag by picking the first choice
 * 'maximumSelectionSize' => 3, // Максимальное количество выбираемых элементов
 * ================================================================
 *
 * @package kamaelkz\yii2admin\v1\widgets\formelements\select2
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class Select2 extends InputWidget
{
    use WidgetTrait;

    /**
     * @var ActiveForm
     */
    public $form;
    /**
     * @var array
     */
    public $data = [];

    /**
     * @var bool
     */
    public $smart = true;
    /**
     * @var array
     */
    private $hashMap = [];

    /**
     * @inheritDoc
     */
    public function beforeRun()
    {
        $this->registerBundle();

        return parent::beforeRun();
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if(! $this->form || (! $this->form instanceof ActiveForm)){
            throw new InvalidConfigException(
                'Свойство {form} не может быть пустым или не является экземпляром класса yii\widgets\ActiveForm'
            );
        }
        $this->setOptions();
        echo $this->renderHtml();
    }

    protected function setOptions()
    {
        $this->options['class'] = implode(' ', [
            'select2', isset($this->options['class']) ? $this->options['class'] : ''
        ]);
        if (isset($this->options['prompt'])) {
            $this->options['data-placeholder'] = $this->options['prompt'];
        }
        if (!isset($this->options['data-placeholder'])) {
            $this->options['data-placeholder'] = '';
        }
        if (!isset($this->options['width'])) {
            $this->options['width'] = '100%';
        }

        $options = $this->options ? $this->options : '';
        unset($options['class'], $options['id']);
        $encodeOptions = $options ? Json::encode($options) : '';
        $hash = hash('crc32', $encodeOptions);
        $variable = "select2_option_{$hash}";
        if(! isset($this->hashMap[$hash])) {
            $this->hashMap[$hash] = $hash;

            $view = Yii::$app->getView();
            $view->registerJs("var {$variable} = {$encodeOptions};\n", $view::POS_END);
        }

        $this->options['data-plugin-options-variable'] = $variable;
        if(isset($this->options['multiple'])) {
            $this->smart = false;
        }

        if($this->smart === true) {
            $this->options['data-smart-select'] = 'true';
        }
    }

    /**
     * @return string
     */
    protected function renderHtml()
    {
        $smartInput = $this->getSmartInput();

        if ($this->hasModel()) {
            $dropDown =  Html::activeDropDownList($this->model, $this->attribute, $this->data, $this->options);
        } else {
            $dropDown =  Html::dropDownList($this->name, $this->value, $this->data, $this->options);
        }

        return $dropDown . $smartInput;
    }

    /**
     * @return string
     */
    protected function getSmartInput()
    {
        if(! $this->smart) {
            return null;
        }

        if($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
            $inputValue = $this->data[$value] ?? null;
        } else {
            $inputValue = $this->data[$this->value] ?? null;
        }

        if($inputValue === null) {
            $inputValue = Html::tag('span', $this->options['data-placeholder'], ['class' => 'select2-smart-input-placeholder']);
        }
        # скрывает выпадающий список
        $this->options['class'] .= ' d-none';
        $inputOptions = [
            'class' => 'form-control select2-smart-input',
            'disabled' => 'disabled'
        ];

        return Html::tag('div', $inputValue, $inputOptions);
    }
}