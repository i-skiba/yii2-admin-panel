<?php

namespace kamaelkz\yii2admin\v1\modules\hints\widgets;

use Yii;
use yii\helpers\Html;
use kamaelkz\yii2admin\v1\modules\hints\enum\AdminHintsTypeEnum;
use concepture\yii2logic\widgets\Widget;
use kamaelkz\yii2admin\v1\modules\hints\services\AdminHintsService;;

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
    public $textColor = 'text-grey-400';
    /**
     * @var string
     */
    public $extendClassOptions = '';
    /**
     * @var int
     */
    public $type = AdminHintsTypeEnum::POPOVER;
    /**
     * @var string
     */
    private $tag;

    /**
     * @var array
     */
    public $options = [
        'data-origin-title' => null,
        'data-content' => null,
        'data-trigger' => 'click',
        'data-html' => 'true',
        'data-placement' =>'top'
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
    public function beforeRun()
    {
        switch ($this->type) {
            case AdminHintsTypeEnum::INFO :
                $this->options['class'] = "alert alert-info alert-styled-left alert-arrow-left alert-bordered yii2admin_hints_info d-none";
                $this->tag = 'div';
                break;
            default :
                $this->options['class'] = "icon-question4 yii2admin_hints_popover d-none {$this->textColor}";
                $this->tag = 'span';
                break;
        }

        return parent::beforeRun();
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        parent::run();
        $this->getService()->pushStack($this);
        $this->options['id'] = "yii2admin_hint_{$this->name}";
        if( $this->extendClassOptions) {
            $this->options['class'] .= " {$this->extendClassOptions}";
        }

        return Html::tag($this->tag, null, $this->options);
    }
}