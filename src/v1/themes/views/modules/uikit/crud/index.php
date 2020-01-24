<?php

use yii\grid\GridView;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use kamaelkz\yii2admin\v1\widgets\lists\grid\EditableColumn;
use concepture\yii2handbook\actions\PositionSortIndexAction;

/* @var $this \kamaelkz\yii2admin\v1\themes\components\view\View */
/* @var $searchModel \kamaelkz\yii2admin\v1\modules\uikit\search\CrudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->setTitle(Yii::t('yii2admin', 'Интерфейс'));
$this->pushBreadcrumbs($this->title);
$this->viewHelper()->pushPageHeader(
    [PositionSortIndexAction::actionName()],
    Yii::t('yii2admin', 'Сортировка'),
    'icon-sort'
);
$this->viewHelper()->pushPageHeader();

?>

<?php Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'searchVisible' => true,
        'searchParams' => [
            'model' => $searchModel
        ],
        'dragAndDrop' => true,
        'dragAndDropOptions' => [
            'sortActionName' => 'sort-crud'
        ],
        'columns' => [
            'id',
            [
                'attribute' => 'text_input',
                'class' => EditableColumn::class
            ],
            'mask',
            [
                'attribute' => 'sort',
                'class' => EditableColumn::class,
                'contentOptions' => [
                    'style' => 'width:15%',
                    'class'=> 'text-center'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn'
            ],
        ],
    ]); ?>
<?php Pjax::end();?>
