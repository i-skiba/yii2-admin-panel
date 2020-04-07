<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use concepture\yii2logic\enum\StatusEnum;
use concepture\yii2logic\enum\IsDeletedEnum;
use \concepture\yii2user\enum\UserRoleEnum;

$is_superadmin = Yii::$app->getUser()->can(UserRoleEnum::SUPER_ADMIN);

$this->setTitle(Yii::t('yii2admin', 'Список'));
$this->pushBreadcrumbs($this->title);
if($is_superadmin) {
    $this->viewHelper()->pushPageHeader(null, null, null,
        [
            'class' => 'magic-modal-control',
            'data-url' => Url::to(['create']),
            'data-modal-size' => 'modal-lg',
            'data-callback' => 'function(){callbackHelper.reloadPjax("#list-pjax")}'
        ]
    );
}
?>
<?php Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'searchVisible' => true,
        'searchParams' => [
            'model' => $searchModel
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'visible' => $is_superadmin
            ],
            [
                'attribute' => 'name',
                'visible' => $is_superadmin,
                'value' => function ($model) use($is_superadmin){
                    return Html::tag(
                        'span',
                        $model->name,
                        [
                            'class' => 'editable-column magic-modal-control',
                            'data-url' => Url::to(['update', 'id' => $model['id'], 'locale' => $model['locale']]),
                            'data-modal-size' => 'modal-lg',
                            'data-callback' => "function(){callbackHelper.reloadPjax('#list-pjax')}"
                        ]
                    );
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'caption',
                'contentOptions' => [
                    'style' => 'width:30%'
                ],
                'value' => function ($model) use($is_superadmin){

                    if($is_superadmin) {
                        return $model->caption;
                    }

                    return Html::tag(
                        'span',
                        $model->caption,
                        [
                            'class' => 'editable-column magic-modal-control',
                            'data-url' => Url::to(['update', 'id' => $model['id'], 'locale' => $model['locale']]),
                            'data-modal-size' => 'modal-lg',
                            'data-callback' => "function(){callbackHelper.reloadPjax('#list-pjax')}"
                        ]
                    );
                },
                'format' => 'raw'
            ],
            [
                'attribute'=>'status',
                'filter'=> StatusEnum::arrayList(),
                'value'=>function($data) {
                    return $data->statusLabel();
                }
            ],
            [
                'label' => Yii::t('yii2admin','Прогресс'),
                'headerOptions' => [
                    'class' => 'text-center',
                ],
                'contentOptions' => [
                    'class' => 'text-center'
                ],
                'value' => function ($model) {
                    $i = 0;
                    $j = 2;
                    $color = 'danger';
                    if($model->caption) {
                        $color = 'warning';
                        $i ++;
                    }

                    if($model->value) {
                        $color = 'success';
                        $i ++;
                    }

                    return Html::tag('span', "{$i}/{$j}", ['class' => "badge badge-{$color}"]);
                },
                'format' => 'raw'
            ],
            [
                'class'=>'yii\grid\ActionColumn',
                'template'=>'{view} {update} <div class="dropdown-divider"></div> {activate} {deactivate}',
                'buttons'=>[
                    'view'=> function ($url, $model) {
                        return Html::a(
                            '<i class="icon-file-eye2"></i>' . Yii::t('yii2admin', 'Просмотр'),
                            ['view', 'id' => $model['id'], 'locale' => $model['locale']],
                            [
                                'class' => 'dropdown-item',
                                'aria-label' => Yii::t('yii2admin', 'Просмотр'),
                                'title' => Yii::t('yii2admin', 'Просмотр'),
                                'data-pjax' => '0'
                            ]
                        );
                    },
                    'update'=> function ($url, $model) {
                        if ($model['is_deleted'] == IsDeletedEnum::DELETED){
                            return '';
                        }

                        return Html::a(
                            '<i class="icon-pencil6"></i>'. Yii::t('yii2admin', 'Редактировать'),
                            null,
                            [
                                'data-url' => Url::to(['update', 'id' => $model['id'], 'locale' => $model['locale']]),
                                'class' => 'dropdown-item magic-modal-control',
                                'aria-label' => Yii::t('yii2admin', 'Редактировать'),
                                'title' => Yii::t('yii2admin', 'Редактировать'),
                                'data-pjax' => '0',
                                'data-modal-size' => 'modal-lg',
                                'data-callback' => 'function(){callbackHelper.reloadPjax("#list-pjax")}'
                            ]
                        );
                    },
                    'activate'=> function ($url, $model) {
                        if ($model['is_deleted'] == IsDeletedEnum::DELETED){
                            return '';
                        }

                        if ($model['status'] == StatusEnum::ACTIVE){
                            return '';
                        }

                        return Html::a(
                            '<i class="icon-checkmark4"></i>'. Yii::t('yii2admin', 'Активировать'),
                            ['status-change', 'id' => $model['id'], 'status' => StatusEnum::ACTIVE, 'locale' => $model['locale']],
                            [
                                'class' => 'admin-action dropdown-item',
                                'data-pjax-id' => 'list-pjax',
                                'data-pjax-url' => Url::current([], true),
                                'data-swal' => Yii::t('yii2admin' , 'Активировать'),
                            ]
                        );
                    },
                    'deactivate'=> function ($url, $model) {
                        if ($model['is_deleted'] == IsDeletedEnum::DELETED){
                            return '';
                        }
                        if ($model['status'] == StatusEnum::INACTIVE){
                            return '';
                        }
                        return Html::a(
                            '<i class="icon-cross2"></i>'. Yii::t('yii2admin', 'Деактивировать'),
                            ['status-change', 'id' => $model['id'], 'status' => StatusEnum::INACTIVE, 'locale' => $model['locale']],
                            [
                                'class' => 'admin-action dropdown-item',
                                'data-pjax-id' => 'list-pjax',
                                'data-pjax-url' => Url::current([], true),
                                'data-swal' => Yii::t('yii2admin' , 'Деактивировать'),
                            ]
                        );
                    }
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end();?>
