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
?>
<?php if (isset($originModel) && method_exists($originModel, 'toString')) :?>
    <?php $this->setTitlePrefix(Yii::t('yii2admin', 'Аудит'));?>
    <?php $this->setTitle((string) $originModel->toString());?>
<?php else:?>
    <?php $this->setTitle(Yii::t('yii2admin', 'Аудит'));?>
<?php endif?>
<?php
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
                    'label' => Yii::t('common', 'Пользователь'),
                    'value' => function ($data) {
                        $user_id = $data->user_id;
                        $user = User::findIdentity($user_id);
                        if(! $user) {
                            return null;
                        }

                        return Html::tag(
                            'a',
                            $user->toString(),
                            [
                                'class' => 'badge bg-primary',
                                'target' => '_blank',
                                'href' => Url::to(['user/user/view', 'id' => $user_id])
                            ]
                        );
                    },
                    'format' => 'raw',
                ],
                'action',
//                'model_pk',
                'created_at',
                isset($models) ? [
                    'attribute' => 'field',
                    // TODO do something with this
                    'value' => function ($data) use ($models) {
                        return $models[(int) $data->model_pk]->caption;
                    },
                    'format' => 'raw',

                ] : 'field',
                [
                    'label' => Yii::t('yii2admin', 'Разница'),
                    'value' => function ($model) {
                        $diff = $model->getDiffHtml();
                        // TODO to view
                        $header = Yii::t('yii2admin', 'Показать');
                        return <<<HTML
                            <div class='text-center'>
                            <span class="font-weight-semibold cursor-pointer" data-toggle="collapse" data-target="#collapse-text-{$model->id}" aria-expanded="true">
                                {$header}
                            </span>
                            </div>
                            <div class="collapse" id="collapse-text-{$model->id}" style="">
                                {$diff}
                            </div>
HTML;

                    },
                    'headerOptions' => [
                        'style' => 'width:35%',
                        'class' => 'text-center'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                    'format' => 'raw',
                ],
                [
                    'label' => Yii::t('yii2admin', 'Действия'),
                    'value' => function ($model) {
                        return Html::a('<i class="icon-arrow-left13"></i> ' . Yii::t('yii2admin', 'Востановить'), Url::to(['audit-rollback', 'id' => $model->id, 'model_pk' => $model->model_pk, 'modelClass' => $model->model]), [
                            'class' => 'admin-action list-icons-item btn bg-success',
                            'data-pjax-id' => 'list-pjax',
                            'data-pjax-url' => Url::current([], true),
                            'data-swal' => Yii::t('yii2admin' , 'Вернуть старое значение')
                        ]);
                    },
                    'headerOptions' => [
                        'class' => 'text-center'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                    'format' => 'raw',
                ],
            ]
        ]); ?>
    </div>
<?php Pjax::end(); ?>
