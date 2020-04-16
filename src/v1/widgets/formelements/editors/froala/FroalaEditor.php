<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\editors\froala;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\InputWidget;
use yii\helpers\Inflector;
use yii\web\JsExpression;
use yii\helpers\Url;

/**
 * Виджет редактора Froala Wysiwyg editor
 *
 * https://github.com/froala/yii2-froala-editor
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class FroalaEditor extends InputWidget
{
    const PLUGIN_NAME = 'FroalaEditor';

    /**
     * @var array плагины для подключения
     */
    public $clientPlugins;

    /**
     * @var array исключенные плагины
     */
    public $excludedPlugins = [];

    /**
     * @var array настройки плагина
     */
    public $clientOptions = [];

    /**
     * @var string
     */
    public $template = 'view';

    /**
     * @inheritDoc
     */
    public function run()
    {
        if(! $this->hasModel()) {
            throw new InvalidConfigException("'model' and 'attribute' properties must be specified.");
        }

        $class = ' yii2admin_editor';
        if(isset($this->options['class'])) {
            $this->options['class'] .= $class;
        } else {
            $this->options['class'] = $class;
        }

        # todo новые типы
        if(! isset($this->options['data-type'])) {
            $this->options['data-type'] = 'default';
        }

        $input = Html::activeTextarea($this->model, $this->attribute, $this->options);

        # установка опций по умолчанию
        $this->clientOptions += $this->getDefaultClientOptions();
        # выставляем минимальную высоту блока обертки над виджетом
        $minHeight = ($this->clientOptions['height'] ?? $this->clientOptions['heightMin'] ?? 70 ) + 95;

        echo  $this->render($this->template, [
            'input' => $input,
            'id' => $this->getId(),
            'model' => $this->model,
            'attribute' => $this->attribute,
            'minHeight' => $minHeight,
        ]);

        $this->registerClientScript();
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        $asset = Bundle::register($view);
        if(! $this->clientPlugins) {
            $this->clientPlugins = Bundle::DEFAULT_PLUGIN_SET;
        }

        $plugin_names = $asset->registerClientPlugins($this->clientPlugins, $this->excludedPlugins);
        //theme
        $themeType = isset($this->clientOptions['theme']) ? $this->clientOptions['theme'] : 'default';
        if ($themeType != 'default') {
            $view->registerCssFile("{$asset->baseUrl}/css/themes/{$themeType}.css", ['depends' => Bundle::class]);
        }
        //language
        $langType = isset($this->clientOptions['language']) ? $this->clientOptions['language'] : 'en_gb';
        if ($langType != 'es_gb') {
            $view->registerJsFile("{$asset->baseUrl}/js/languages/{$langType}.js", ['depends' => Bundle::class]);
        }

        $id = $this->options['id'];
        if (empty($this->clientPlugins)) {
            $pluginsEnabled = false;
        } else {
            $pluginsEnabled = array_diff($plugin_names, $this->excludedPlugins ?: []);
        }

        if(!empty($pluginsEnabled)){
            foreach($pluginsEnabled as $key =>$item){
                $pluginsEnabled[$key] = lcfirst (Inflector::camelize($item));
            }
        }

        $jsOptions = array_merge($this->clientOptions, $pluginsEnabled ? ['pluginsEnabled' => $pluginsEnabled] : []);
        $jsOptions = Json::encode($jsOptions);
        $js = new JsExpression("
            if ($('#{$id}').length !== 0) {
                editorHelper.extendConfig('{$this->options['data-type']}', {$jsOptions});
                editorHelper.add('#{$id}', '{$this->options['data-type']}');
            }
        ");
        $view->registerJs($js->expression, View::POS_LOAD);
    }

    /**
     * Настройки плагина по умолчанию
     *
     * @return array
     */
    private function getDefaultClientOptions()
    {
        return [
            'language' => Yii::$app->language,
            'key' => getenv('FROALA_LICENSE_KEY'),
            'imageUploadURL' => Url::to(['/cdn']),
        ];
    }
}