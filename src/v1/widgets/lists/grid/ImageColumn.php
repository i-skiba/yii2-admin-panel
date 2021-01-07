<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use yii\helpers\Json;
use yii\grid\DataColumn;
use yii\helpers\Html;

/**
 * Колонка для вывода изображения
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ImageColumn extends DataColumn
{
    /**
     * @var array
     */
    public $format = 'raw';
    /**
     * @var array
     */
    public $headerOptions = [
        'style' => 'width:10%',
        'class' => 'text-center'
    ];
    /**
     * @var array
     */
    public $contentOptions = [
        'class' => 'text-center'
    ];

    /**
     * @var array
     */
    public $imageOptions = [
        'style' => 'height: 65px'
    ];
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $attribute = $model->{$this->attribute} ?? null;
        if(! $attribute) {
            return null;
        }

        if(! is_array($attribute)) {
            $attribute = Json::decode($attribute);
        }

        $source = $attribute['path'] ?? null;
        if(! $source) {
            return null;
        }

        return Html::img($source, $this->imageOptions);
    }
}