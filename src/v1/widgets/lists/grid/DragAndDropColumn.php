<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use concepture\yii2handbook\enum\SettingsTypeEnum;
use kamaelkz\yii2admin\v1\actions\EditableColumnAction;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class DragAndDropColumn extends \yii\grid\DataColumn
{
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
            $content = <<<HTML
                <div class="">
                    <i class="icon-dots dragula-handle"></i>
                    <span class="ml-2">{$content}</span>
                </div>
HTML;
        }

        return Html::tag('td', $content, $options);
    }
}