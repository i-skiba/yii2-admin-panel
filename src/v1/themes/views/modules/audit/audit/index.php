<?php

use yii\web\View;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use concepture\yii2user\models\User;
use kamaelkz\yii2admin\v1\modules\audit\search\AuditSearch;
use kamaelkz\yii2admin\v1\modules\audit\themes\bundles\AuditBundle;

/**
 * @var View $this
 */

$this->setTitle(Yii::t('yii2admin', 'Аудит'));
$this->pushBreadcrumbs($this->title);
$this->registerAssetBundle(AuditBundle::class);

$dataProvider->setSort([
    'defaultOrder' => [
        'created_at' => SORT_DESC
    ]
]);
?>

<?php Pjax::begin(['id' => 'list-pjax']); ?>
<div class="table-responsive">
    <?= GridView::widget([
        'layout' => '{summary}{pager}<br/>{items}{pager}',
        'dataProvider' => $dataProvider,
        'searchVisible' => true,
        'searchParams' => [
            'model' => $searchModel
        ],
//        'searchView' => '@yii2admin/themes/views/modules/audit/audit/_search',
        'columns' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return $data->user_id;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'username',
                'label' => Yii::t('yii2admin', 'Имя пользователя'),
                'value' => function ($data) {
                    $user = User::findIdentity($data->user_id);
                    return $user->toString();
                },
                'format' => 'raw',
            ],
            'action',
            'model',
            'model_pk',
            'field',
            [
                'label' => Yii::t('audit', 'Разница'),
                'value' => function ($model) {
                    $diff = $model->getDiffHtml();
                    // TODO to view
                    return "<div class='text-center'><span class=\"font-weight-semibold cursor-pointer\" data-toggle=\"collapse\" data-target=\"#collapse-text-{$model->id}\" aria-expanded=\"true\">" . Yii::t('yii2admin', 'Показать') . "</span></div><div class=\"collapse\" id=\"collapse-text-{$model->id}\" style=\"\">{$diff}</div>";
                },
                'format' => 'raw',
            ],
            'created_at',
            [
                'label' => Yii::t('audit', 'Действия'),
                'value' => function ($item) {
                    return Html::a('<i class="icon-rotate-ccw3"></i>', Url::to(['rollback', 'id' => $item->id, 'model_pk' => $item->model_pk, 'modelClass' => $item->model]), [
                        'class' => 'admin-action btn btn-icon bg-success-400',
                        'data-pjax-id' => 'list-pjax',
                        'data-pjax-url' => Url::current([], true),
                        'data-swal' => Yii::t('yii2admin' , 'Вернуть старое значение')
                    ]);
                },
                'format' => 'raw',
            ],
        ]
    ]); ?>
</div>
<?php Pjax::end(); ?>
