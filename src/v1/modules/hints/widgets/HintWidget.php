<?php

namespace kamaelkz\yii2admin\v1\modules\hints\widgets;

use Yii;
use concepture\yii2logic\widgets\Widget;
use kamaelkz\yii2admin\v1\modules\hints\services\AdminHintsService;
use kamaelkz\yii2admin\v1\modules\hints\dto\AdminHintsDto;

/**
 * Виджет подсказок
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class HintWidget extends Widget
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $caption;

    /**
     * @var string
     */
    public $viewPath = 'view';

    /**
     * @var string
     */
    public $textColor = 'text-grey-400';

    /**
     * @var string
     */
    public $extendClassOptions = '';

    /**
     * @var array
     */
    public $options = [
        'data-title' => null,
        'data-content' => null,
        'data-init' => false,
    ];

    /**
     * @return AdminHintsService
     */
    public function getService()
    {
        return Yii::$app->adminHintsService;
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        parent::run();
        $object = AdminHintsDto::make($this->name, $this->caption);
        $this->getService()->pushStack($object);
        $this->options['id'] = "yii2admin_hint_{$this->name}";
        $this->options['class'] = "icon-question4 yii2admin_hints d-none {$this->textColor}";
        if( $this->extendClassOptions) {
            $this->options['class'] .= " {$this->extendClassOptions}";
        }

        return $this->render($this->viewPath, [
            'options' => $this->options
        ]);
    }
}