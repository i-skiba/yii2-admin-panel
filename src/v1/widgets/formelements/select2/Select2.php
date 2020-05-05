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

    const HASH_VAR_BASE_NAME = 'select2_';

    /** @var ActiveForm */
    public $form;
    /** @var array */
    public $data = [];
    /** @var string the hashed global variable name storing the pluginOptions */
    private $_hashVar;

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
        $this->options['class'] = join(' ', [
            'select', isset($this->options['class']) ? $this->options['class'] : ''
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

        $encOptions = $this->options ? Json::encode($this->options) : '';
        $this->_hashVar = static::HASH_VAR_BASE_NAME . hash('crc32', $encOptions);
        $this->options['id'] = $this->_hashVar;
        $view->registerJs("var {$this->_hashVar} = {$encOptions};\n", $view::POS_END);
    }

    /**
     * This registers the necessary JavaScript code.
     */
    private function registerClientScript()
    {
        $view = $this->getView();
        $this->registerBundle();
        $this->registerOptions($view);

        $script = <<<JS
    $('#{$this->_hashVar}').select2({$this->_hashVar});
    $(document).on('afterInsert', '.dynamicform_wrapper', function (e, clone) {
        let selectInput = $(clone).find('.select');
        if (selectInput.length !== 0) {
            $(clone).find('.select').select2();
        }
    });
    $('#{$this->_hashVar}').on('select2:clearing', function (e) {
        e.preventDefault();
        var el = $(this);
        componentNotify.sweetAlert(yii2admin.t('Confirm'), function () {
            el.val(null).trigger("change");
            el.select2("open");
        });
    });
JS;

        $view->registerJs($script, View::POS_END);
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