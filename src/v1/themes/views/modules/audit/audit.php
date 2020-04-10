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
 * @var \yii\db\ActiveRecord $originModel
 * @var bool $filter
 * @var array $params
 * @var ActiveQuery $query
 * @var array $columns
 */

$this->setTitle(Yii::t('yii2admin', 'Аудит'));
$this->pushBreadcrumbs(['label' => $model::label(), 'url' => ['index']]);
$this->pushBreadcrumbs($this->title);
if (isset($originModel)) {
    $this->viewHelper()->pushPageHeader(['update', 'id' => $originModel->id], Yii::t('yii2admin', 'Редактирование'),'icon-pencil6');
}
$this->viewHelper()->pushPageHeader(['index'], $model::label(),'icon-list');


$params = isset($params) ? $params : Yii::$app->request->get();
$extendColumns = isset($extendColumns) ? $extendColumns : [];

$this->registerAssetBundle(AuditBundle::class);

$auditSearch = new AuditSearch();
if (isset(Yii::$app->request->get()['AuditSearch'])) {
    $auditSearch->load($params);
}
$auditSearch->extendQuery($query);

$auditDataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'defaultOrder' => [
            'id' => SORT_DESC
        ]
    ]
]);

?>

<?php Pjax::begin(['id' => 'list-pjax']); ?>
<?php if (isset($originModel) && method_exists($originModel, 'toString')): ?>
    <h4><?= $originModel->toString(); ?></h4>
<?php endif; ?>
<div class="table-responsive">
    <?= GridView::widget([
        'layout' => '{summary}{pager}<br/>{items}{pager}',
        'dataProvider' => $auditDataProvider,
        'searchVisible' => true,
        'searchParams' => [
            'model' => $auditSearch
        ],
        'searchView' => '@yii2admin/themes/views/modules/audit/_search',
        'columns' => [
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
//            'model',
            'model_pk',
            isset($models) ? [
                'attribute' => 'field',
                // TODO do something with this
                'value' => function ($data) use ($models) {
                    return $models[(int) $data->model_pk]->caption;
                },
                'format' => 'raw',
            ] : 'field',
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
                'value' => function ($model) {
                    return Html::a('<i class="icon-rotate-ccw3"></i>', Url::to(['audit-rollback', 'id' => $model->id, 'model_pk' => $model->model_pk]), [
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
