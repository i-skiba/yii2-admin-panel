<?php

use yii\grid\GridView;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;

/* @var $this \kamaelkz\yii2admin\v1\themes\components\view\View */
/* @var $searchModel \kamaelkz\yii2admin\v1\modules\uikit\search\CrudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->setTitle(Yii::t(yii2admin, 'CRUD'));
$this->pushBreadcrumbs($this->title);
$this->viewHelper()->pushPageHeader();

?>

<?php Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'mask',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end();?>
