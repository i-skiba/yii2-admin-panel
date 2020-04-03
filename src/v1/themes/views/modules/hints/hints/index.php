<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use concepture\yii2logic\enum\StatusEnum;
use concepture\yii2logic\enum\IsDeletedEnum;
use \concepture\yii2user\enum\UserRoleEnum;

$this->setTitle(Yii::t('yii2admin', 'Список'));
$this->pushBreadcrumbs($this->title);
if(Yii::$app->getUser()->can(UserRoleEnum::SUPER_ADMIN)) {
    $this->viewHelper()->pushPageHeader();
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
            'id',
            'name',
            'caption',
            [
                'attribute'=>'status',
                'filter'=> StatusEnum::arrayList(),
                'value'=>function($data) {
                    return $data->statusLabel();
                }
            ],
            'created_at',
            [
                'attribute'=>'is_deleted',
                'filter'=> IsDeletedEnum::arrayList(),
                'value'=>function($data) {
                    return $data->isDeletedLabel();
                }
            ],
            [
                'class'=>'yii\grid\ActionColumn',
                'template'=>'{view} {update} <div class="dropdown-divider"></div> {activate} {deactivate} {delete}',
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
                            ['update', 'id' => $model['id'], 'locale' => $model['locale']],
                            [
                                'class' => 'dropdown-item',
                                'aria-label' => Yii::t('yii2admin', 'Редактировать'),
                                'title' => Yii::t('yii2admin', 'Редактировать'),
                                'data-pjax' => '0'
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
                    },
                    'delete'=> function ($url, $model) {
                        if ($model['is_deleted'] == IsDeletedEnum::DELETED){
                            return '';
                        }

                        return Html::a(
                            '<i class="icon-trash"></i>'. Yii::t('yii2admin', 'Удалить'),
                            ['delete', 'id' => $model['id'], 'locale' => $model['locale']],
                            [
                                'class' => 'admin-action dropdown-item',
                                'data-pjax-id' => 'list-pjax',
                                'data-pjax-url' => Url::current([], true),
                                'data-swal' => Yii::t('yii2admin' , 'Удалить'),
                            ]
                        );
                    }
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end();?>
