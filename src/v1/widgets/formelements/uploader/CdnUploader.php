<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\uploader;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\helpers\Url;
use concepture\yii2logic\traits\WidgetTrait;
use common\components\cdn\pojo\CdnImagePojo;

/**
 * Аплодер
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CdnUploader extends InputWidget
{
    use WidgetTrait;

    /**
     * @var string
     */
    public $url = '/cdn';

    /**
     * @var string
     */
    public $hint;

    /**
     * @var int
     */
    public $width = 0;

    /**
     * @var int
     */
    public $height = 0;

    /**
     * @var string
     */
    public $buttonWrapClass = 'bg-primary';

    /**
     * @var string
     */
    public $buttonIconClass = 'icon-upload';

    /**
     * @var string
     */
    public $strategy = 'default';

    /**
     * @var int
     */
    public $resizeBigger = true;

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var array
     */
    public $clientEvents = [];

    /**
     * @var string
     */
    public $template = 'view';

    /**
     * @var string
     */
    public static $autoIdPrefix = 'cdnUploader';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if(! $this->hasModel()) {
            throw new InvalidConfigException("'model' and 'attribute' properties must be specified.");
        }

        $url = Url::to([$this->url]);
        $this->options['data-url'] = $url;
        $this->clientOptions['url'] = $url;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->setOptions();
        $this->options['id'] = $this->getId();
        $this->options['class'] = 'cdnuploader';
        if($this->model->{$this->attribute}) {
            $this->options['hiddenOptions'] = [
                'value' => $this->model->{$this->attribute}
            ];
        }

        $input = Html::activeFileInput($this->model, $this->attribute, $this->options);

        # todo: адаптировать под файл, пока изображения хватит
        $pojo = new CdnImagePojo();
        $pojo->load($this->model->{$this->attribute}, '');

        echo  $this->render($this->template, [
            'input' => $input,
            'id' => $this->getId(),
            'hint' => $this->hint,
            'buttonWrapClass' => $this->buttonWrapClass,
            'buttonIconClass' => $this->buttonIconClass,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'pojo' => $pojo,
        ]);

        $this->registerBundle();
        $this->registerScript();
    }

    /**
     * @inheritDoc
     */
    public function registerScript()
    {
        $view = $this->getView();
        $id = $this->getId();
        $js = [];
        if (! empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
        }

        if(! $js) {
            return null;
        }

        $view->registerJs(implode("\n", $js));
    }

    /**
     * Установка атрибута data-options, передача настроек загрузки
     */
    protected function setOptions()
    {
        $params = [
            'source' => $this->strategy,
            'resize_bigger' => (int) $this->resizeBigger,
            'files_limit' => 1
        ];

        if($this->width > 0 && $this->height > 0) {
            $params['size'] = "{$this->width}x{$this->height}";
            if(! $this->hint) {
                $this->hint = Yii::t(
                    'yii2admin', 'Допустимый размер изображения: {w}x{h} px',
                    [
                        'w' => $this->width,
                        'h' => $this->height
                    ]
                );
            }
        }

        $this->options = $this->options + ['data-options' => $params];
    }
}