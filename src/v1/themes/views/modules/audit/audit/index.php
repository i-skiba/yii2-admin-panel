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
            'model',
            'model_pk',
            'field',
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
            'created_at',
            [
                'label' => Yii::t('yii2admin', 'Действия'),
                'value' => function ($item) {
                    return Html::a(
                            '<i class="icon-arrow-left13"></i> ' . Yii::t('yii2admin', 'Востановить'),
                            Url::to(['audit-rollback', 'id' => $item->id, 'model_pk' => $item->model_pk, 'modelClass' => $item->model]
                        ), [
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
