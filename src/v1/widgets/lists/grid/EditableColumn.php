<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use concepture\yii2handbook\enum\SettingsTypeEnum;
use kamaelkz\yii2admin\v1\actions\EditableColumnAction;

/**
 * Редактируемая колонка
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class EditableColumn extends \yii\grid\DataColumn
{
    /**
     * @var int
     */
    public $type = SettingsTypeEnum::TEXT;
    /**
     * @var bool
     */
    public $required = true;
    /**
     * @var array
     */
    public $options = [];
    /**
     * @var \Closure
     */
    public $url;
    /**
     * @var \Closure
     */
    public $content;
    /**
     * @var string
     */
    public $modalSize = 'sm';

    /**
     * @inheritDoc
     */
    public function renderDataCell($model, $key, $index)
    {
        if($this->url && ! $this->url instanceof \Closure) {
            throw new InvalidConfigException('Property `url` must be instance of \Closure');
        }

        if($this->content && ! $this->content instanceof \Closure) {
            throw new InvalidConfigException('Property `content` must be instance of \Closure');
        }

        if ($this->contentOptions instanceof \Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }

        if(! $this->content) {
            $content = $this->renderDataCellContent($model, $key, $index);
        } else if($this->content instanceof \Closure) {
            $content = call_user_func($this->content, $model, $key, $index, $this);
        }

        if($this->attribute) {
            $content = Html::tag('span', $content, $this->getOptions($model));
        }

        return Html::tag('td', $content, $options);
    }

    /**
     * Инициализация редактируемой колонки
     *
     * @param ActiveRecord $model
     *
     * @return array
     */
    protected function getOptions($model)
    {
        if(! $this->attribute) {
            return [];
        }

        if(is_array($model)) {
            $pk = $model['id'];
        } else {
            $pk = $model->getPrimaryKey();
        }

        if(! $this->url) {
            $route = [
                EditableColumnAction::actionName(),
                'column' => $this->attribute,
                'pk' => $pk,
                'type' => $this->type,
                'required' => $this->required
            ];
        } else {
            $route = call_user_func($this->url, $model);
        }

        $url = is_array($route) ? Url::to($route) : $route;
        $defaultOptions = [
            'class' => 'magic-modal-control editable-column',
            'data-url' => $url,
            'data-modal-size' => "modal-{$this->modalSize}",
            'data-callback' => 'function(){ callbackHelper.reloadPjax("#list-pjax"); }'
        ];

        if(! $this->options) {
            return $defaultOptions;
        }

        return ArrayHelper::merge($defaultOptions, $this->options);
    }
}