<?php

use yii\grid\GridView;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;

/* @var $this \kamaelkz\yii2admin\v1\themes\components\view\View */
/* @var $searchModel \kamaelkz\yii2admin\v1\modules\uikit\search\CrudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->setTitle(Yii::t('yii2admin', 'Интерфейс'));
$this->pushBreadcrumbs($this->title);
$this->viewHelper()->pushPageHeader();

?>

<?php Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'searchVisible' => true,
        'searchParams' => [
            'model' => $searchModel
        ],
        'columns' => [
            'id',
            'mask',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end();?>
