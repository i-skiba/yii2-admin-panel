<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use yii\widgets\DetailView;

$this->setTitle(Yii::t('yii2admin', 'Просмотр записи'));
$this->pushBreadcrumbs(['label' => Yii::t('yii2admin', 'Интерфейс'), 'url' => ['index']]);
$this->pushBreadcrumbs($this->title);

$this->viewHelper()->pushPageHeader();
$this->viewHelper()->pushPageHeader(['update' ,'id' => $model->id], Yii::t('yii2admin','Редактировать'), 'icon-pencil6');
$this->viewHelper()->pushPageHeader(['index'], Yii::t('yii2admin', 'Список'),'icon-list');

?>

<?php Pjax::begin();?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <h5 class="card-title">
                        <?= $model->text_input;?>
                    </h5>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 text-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-labeled btn-labeled-left dropdown-toggle" data-toggle="dropdown">
                            <b>
                                <i class="icon-cog5"></i>
                            </b>
                            <?= Yii::t('yii2admin', 'Операции');?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                                <?= Html::a(
                                    '<i class="icon-bin2"></i>' . Yii::t('yii2admin', 'Удалить'),
                                    ['delete', 'id' => $model->id],
                                    [
                                        'class' => 'admin-action dropdown-item',
                                        'data-pjax-id' => 'list-pjax',
                                        'data-pjax-url' => Url::current([], true),
                                        'data-swal' => Yii::t('yii2admin' , 'Удалить'),
                                    ]
                                );?>
                                <div class="dropdown-divider"></div>
                                <?= Html::a(
                                    '<i class="icon-question6"></i>' . Yii::t('yii2admin', 'Операция с уведомлением'),
                                    ['notify', 'id' => $model->id],
                                    [
                                        'class' => 'admin-action dropdown-item',
                                        'data-pjax-id' => 'list-pjax',
                                        'data-pjax-url' => Url::current([], true),
                                        'data-swal' => Yii::t('yii2admin' , 'Операция с уведомлением'),
                                    ]
                                );?>
                                <?= Html::a(
                                    '<i class="icon-question6"></i>' . Yii::t('yii2admin', 'Операция с флешем'),
                                    ['flash', 'id' => $model->id],
                                    [
                                        'class' => 'admin-action dropdown-item',
                                        'data-pjax-id' => 'list-pjax',
                                        'data-pjax-url' => Url::current([], true),
                                        'data-swal' => Yii::t('yii2admin' , 'Операция с флешем'),
                                    ]
                                );?>
                                <?= Html::a(
                                    '<i class="icon-question6"></i>' . Yii::t('yii2admin', 'Операция с редиректом'),
                                    ['redirect', 'id' => $model->id],
                                    [
                                        'class' => 'admin-action dropdown-item',
                                        'data-swal' => Yii::t('yii2admin' , 'Операция с редиректом'),
                                    ]
                                );?>
                                <?= Html::a(
                                    '<i class="icon-question6"></i>' . Yii::t('yii2admin', 'Операция с колбэком'),
                                    ['callback', 'id' => $model->id],
                                    [
                                        'class' => 'admin-action dropdown-item',
                                        'data-pjax-id' => 'list-pjax',
                                        'data-pjax-url' => Url::current([], true),
                                        'data-swal' => Yii::t('yii2admin' , 'Операция с колбэком'),
                                        'data-callback' => new \yii\web\JsExpression('
                                            function( response ){
                                                console.log(response);
                                                alert("this function will remove sidebar");
                                                $sidebar = $(".sidebar");
                                                $sidebar.html(response);
                                            }
                                        '),
//                                        'data-callback' => new \yii\web\JsExpression('
//                                            callbackHelper.reloadList("list-pjax")
//                                        ')
                                    ]
                                );?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
            ]) ?>
        </div>
    </div>
<?php Pjax::end(); ?>
