<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\dynamicform;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
use yii\widgets\ActiveForm;

/**
 * Виджет динамической формы
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class DynamicForm extends \yii\base\Widget
{
    const HASH_VAR_BASE_NAME = 'dynamicform_';
    /**
     * @var string
     */
    public $view = 'view';
    /**
     * @var string
     */
    protected $widgetContainer = 'dynamicform_wrapper';
     /**
     * @var string
     */
    protected $widgetBody = '.dynamic-form-items';
    /**
     * @var string
     */
    protected $widgetItem = '.dynamic-form-item';
    /**
     * @var string
     */
    public $limit = 999;
    /**
     * @var string
     */
    protected $insertButton = '.dynamic-form-add-item';
     /**
     * @var string
     */
    protected $deleteButton = '.dynamic-form-remove-item';
    /**
     * @var string 'bottom' or 'top';
     */
    public $insertPosition = 'bottom';
    /**
     * @var Model|ActiveRecord the model used for the form
     */
    private $model;
     /**
     * @var array
     */
    public $models = [];
    /**
     * @var ActiveForm
     */
    public $form;
    /**
     * @var string form ID
     */
    public $formId;
    /**
     * @var array fields to be validated.
     */
    public $attributes = [];
    /**
     * @var integer
     */
    public $min = 1;
    /**
     * @var bool
     */
    public $dragAndDrop = false;
    /**
     * @var string
     */
    private $_options;
    /**
     * @var string
     */
    private $_insertPositions = ['bottom', 'top'];
    /**
     * @var string the hashed global variable name storing the pluginOptions
     */
    private $_hashVar;

    /**
     * Initializes the widget
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->widgetContainer) || (preg_match('/^\w{1,}$/', $this->widgetContainer) === 0)) {
            throw new InvalidConfigException('Invalid configuration to property "widgetContainer". 
                Allowed only alphanumeric characters plus underline: [A-Za-z0-9_]');
        }

        if (empty($this->widgetBody)) {
            throw new InvalidConfigException("The 'widgetBody' property must be set.");
        }

        if (empty($this->widgetItem)) {
            throw new InvalidConfigException("The 'widgetItem' property must be set.");
        }

        if (empty($this->models)) {
            throw new InvalidConfigException("The 'models' property must be set.");
        }

        if (empty($this->form) || ! $this->form instanceof ActiveForm) {
            throw new InvalidConfigException("The 'form' property must be set and must extend from '\\yii\\base\\Model'.");
        }

        $this->model = reset($this->models);
        if(! $this->model instanceof \yii\base\Model) {
            throw new InvalidConfigException("The 'model' property must be set and must extend from '\\yii\\widgets\\AvtiveForm'.");
        }

        if (empty($this->formId)) {
            throw new InvalidConfigException("The 'formId' property must be set.");
        }

        if (empty($this->insertPosition) || ! in_array($this->insertPosition, $this->_insertPositions)) {
            throw new InvalidConfigException("Invalid configuration to property 'insertPosition' (allowed values: 'bottom' or 'top')");
        }

        if (empty($this->attributes) || !is_array($this->attributes)) {
            throw new InvalidConfigException("The 'attributes' property must be set.");
        }

        $this->initOptions();
    }

    /**
     * Initializes the widget options
     */
    protected function initOptions()
    {
        $this->_options['widgetContainer'] = $this->widgetContainer;
        $this->_options['widgetBody']      = $this->widgetBody;
        $this->_options['widgetItem']      = $this->widgetItem;
        $this->_options['limit']           = $this->limit;
        $this->_options['insertButton']    = $this->insertButton;
        $this->_options['deleteButton']    = $this->deleteButton;
        $this->_options['insertPosition']  = $this->insertPosition;
        $this->_options['formId']          = $this->formId;
        $this->_options['min']             = $this->min;
        $this->_options['fields']          = [];

        foreach ($this->attributes as $attribute => $settings) {
             $this->_options['fields'][] = [
                'id' => Html::getInputId($this->model, '[{}]' . $attribute),
                'name' => Html::getInputName($this->model, '[{}]' . $attribute)
            ];
        }
    }

    protected function registerOptions($view)
    {
        $encOptions = Json::encode($this->_options);
        $this->_hashVar = static::HASH_VAR_BASE_NAME . hash('crc32', $encOptions);
        $view->registerJs("var {$this->_hashVar} = {$encOptions};\n", $view::POS_END);
    }

    /**
     * Registers the needed assets
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        Bundle::register($view);
        $options = Json::encode($this->_options);
        $this->registerOptions($view);

        $js = 'jQuery("#' . $this->formId . '").yiiDynamicForm(' . $this->_hashVar .');' . "\n";
        $view->registerJs($js, $view::POS_END);

        // add a click handler for the clone button
        $js = 'jQuery("#' . $this->formId . '").on("click", "' . $this->insertButton . '", function(e) {'. "\n";
        $js .= "    e.preventDefault();\n";
        $js .= '    jQuery(".' .  $this->widgetContainer . '").triggerHandler("beforeInsert", [jQuery(this)]);' . "\n";
        $js .= '    jQuery(".' .  $this->widgetContainer . '").yiiDynamicForm("addItem", '. $this->_hashVar . ", e, jQuery(this));\n";
        $js .= "});\n";
        $view->registerJs($js, $view::POS_END);

        // add a click handler for the remove button
        $js = 'jQuery("#' . $this->formId . '").on("click", "' . $this->deleteButton . '", function(e) {'. "\n";
        $js .= "    e.preventDefault();\n";
        $js .= '    jQuery(".' .  $this->widgetContainer . '").yiiDynamicForm("deleteItem", '. $this->_hashVar . ", e, jQuery(this));\n";
        $js .= "});\n";
        $view->registerJs($js, $view::POS_END);
    }

    public function run()
    {
        $content = $this->render($this->view, [
            'header' => $this->getHeader(),
            'body' => $this->getBody(),
            'dragAndDrop' => $this->dragAndDrop
        ]);

        $crawler = new Crawler();
        $crawler->addHTMLContent($content, \Yii::$app->charset);
        $results = $crawler->filter($this->widgetItem);
        $document = new \DOMDocument('1.0', \Yii::$app->charset);
        $document->appendChild($document->importNode($results->first()->getNode(0), true));
        $this->_options['template'] = trim($document->saveHTML());

        if (isset($this->_options['min']) && $this->_options['min'] === 0 && $this->model->isNewRecord) {
            $content = $this->removeItems($content);
        }

        $this->registerClientScript();

        return  Html::tag('div', $content, ['class' => $this->widgetContainer, 'data-dynamicform' => $this->_hashVar]);
    }

    private function removeItems($content)
    {
        $document = new \DOMDocument('1.0', \Yii::$app->charset);
        $crawler = new Crawler();
        $crawler->addHTMLContent($content, \Yii::$app->charset);
        $root = $document->appendChild($document->createElement('_root'));
        $crawler->rewind();
        $root->appendChild($document->importNode($crawler->current(), true));
        $domxpath = new \DOMXPath($document);
        $crawlerInverse = $domxpath->query(CssSelector::toXPath($this->widgetItem));

        foreach ($crawlerInverse as $elementToRemove) {
            $parent = $elementToRemove->parentNode;
            $parent->removeChild($elementToRemove);
        }

        $crawler->clear();
        $crawler->add($document);
        return $crawler->filter('body')->eq(0)->html();
    }

    private function getHeader()
    {
        $result = Html::tag('td', '', []);
        if($this->dragAndDrop) {
            $result .= Html::tag('td', '', []);
        }

        foreach ($this->attributes as $attribute => $settings) {
            $result .= Html::tag('td', $this->model->getAttributeLabel($attribute), ['class' => 'text-center']);
        }

        return Html::tag('tr', $result);
    }

    private function getBody()
    {
        $result = null;
        foreach ($this->models as $key => $model) {
            $dragAndDrop = null;
            if($this->dragAndDrop) {
                $dragAndDrop = $this->dragAndDropControl();
            }

            $item = ($dragAndDrop . $this->removeControl());
            foreach ($this->attributes as $attribute => $settings) {
                $column = null;
                $value = $this->models[$key][$attribute] ?? null;
                if($this->dragAndDrop) {
                    $key = null;
                }

                if(is_callable($settings)) {
                    $column = call_user_func($settings, $model, $this->form, $key, $value);
                } else {
                    $instance = $this->form->field($model, "[$key]{$attribute}")->label(false);
                    if(! is_array($settings)) {
                        $type = $settings;
                        $params = [];
                    } else {
                        $type = $settings['type'];
                        $params = $settings['params'];
                    }

                    $column = call_user_func_array([$instance, $type], $params);
                }

                $item .= Html::tag('td', $column, ['class' => 'text-center']);
            }

            $result .= Html::tag('tr', $item, ['class' => trim($this->widgetItem, '.')]);
        }

        return $result;
    }

   /**
    * Колонка удаления
    *
    * @return string
    */
    private function removeControl()
    {
        $class = trim($this->deleteButton, '.');

        return <<<HTML
            <td class="text-center" style="min-width: 5%;">
                <button type="button" class="btn btn-primary btn-icon {$class}">
                    <i class="icon-minus-circle2 "></i>
                </button>
            </td>
HTML;
    }

    private function dragAndDropControl()
    {
        return $content = <<<HTML
            <td class="text-center" style="min-width: 5%;">
                <div class="mr-3 mt-2">
                    <i class="icon-dots dragula-handle"></i>
                    <span class="ml-2"></span>
                </div>
            </td>
HTML;
    }
}