<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\DetailView;

$this->setTitle(Yii::t('yii2admin', 'Просмотр записи'));
$this->pushBreadcrumbs(['label' => Yii::t('yii2admin', 'CRUD'), 'url' => ['index']]);
$this->pushBreadcrumbs($this->title);

$this->viewHelper()->pushPageHeader();
$this->viewHelper()->pushPageHeader(['update' ,'id' => $model->id], Yii::t('yii2admin','Редактирование'), 'icon-pencil5');
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
                                    '<i class="icon-bin"></i>' . Yii::t('yii2admin', 'Удалить'),
                                    ['delete', 'id' => $model->id],
                                    [
                                        'class' => 'admin-action dropdown-item',
                                        'data-pjax-list' => 'list-pjax',
                                        'data-pjax-url' => Url::current([], true),
                                        'data-swal' => Yii::t('yii2admin' , 'Удалить'),
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
