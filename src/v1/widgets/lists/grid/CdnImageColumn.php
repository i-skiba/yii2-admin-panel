<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use Yii;
use yii\grid\DataColumn;
use yii\helpers\Html;

/**
 * Колонка для вывода изображения
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class CdnImageColumn extends DataColumn
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
     * @return mixed
     */
    public function getCdnService()
    {
        return Yii::$app->cdnService;
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if(
            ! $model->{$this->attribute}
            || ! method_exists($model, 'getImageAttribute')
        ) {
            return null;
        }

        $source = Yii::$app->cdnService->path($model->getImageAttribute($this->attribute));

        return Html::img($source, $this->imageOptions);
    }
}