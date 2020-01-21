<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

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
     * @inheritDoc
     */
    public function renderDataCell($model, $key, $index)
    {
        if ($this->contentOptions instanceof \Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }

        $content = $this->renderDataCellContent($model, $key, $index);
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
    protected function getOptions(ActiveRecord $model)
    {
        if(! $this->attribute) {
            return [];
        }

        $url = Url::to([
            EditableColumnAction::actionName(),
            'column' => $this->attribute,
            'pk' => $model->getPrimaryKey(),
            'type' => $this->type,
            'required' => $this->required
        ]);
        $defaultOptions = [
            'class' => 'magic-modal-control editable-column',
            'data-url' => $url,
            'data-modal-size' => 'modal-sm',
            'data-callback' => 'function(){ callbackHelper.reloadPjax("#list-pjax"); }'
        ];

        if(! $this->options) {
            return $defaultOptions;
        }

        return ArrayHelper::merge($defaultOptions, $this->options);
    }
}