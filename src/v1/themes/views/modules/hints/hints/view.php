<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use yii\helpers\Url;

$this->setTitle(Yii::t('yii2admin', 'Просмотр'));
$this->pushBreadcrumbs(['label' => $model::label(), 'url' => ['index']]);
$this->pushBreadcrumbs($this->title);

$this->viewHelper()->pushPageHeader(
        null,
        Yii::t('yii2admin','Редактирование'),
        'icon-pencil6',
        [
            'data-url' => Url::to(['update', 'id' => $model['id'], 'locale' => $model['locale']]),
            'class' => 'magic-modal-control',
            'data-modal-size' => 'modal-lg',
            'data-callback' => 'function(){callbackHelper.reloadPjax("#list-pjax")}'
        ]
);
$this->viewHelper()->pushPageHeader(['index'], $model::label(),'icon-list');
?>

<?php Pjax::begin();?>

    <?php if (count($model->locales()) > 1): ?>
        <ul class="nav nav-tabs nav-tabs-solid nav-justified bg-light">
            <?php foreach ($model->locales() as $key => $locale):?>
                <li class="nav-item">
                    <?= Html::a(
                        $locale,
                        \yii\helpers\Url::current(['locale' => $key]),
                        ['class' => 'nav-link ' . ($key ==  $model->locale   ? "active" : "")]
                    ) ?>
                </li>
            <?php endforeach;?>
        </ul>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <h5 class="card-title">
                        <?= $model->toString();?>
                    </h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'caption',
                    'value',
                    [
                        'attribute'=>'status',
                        'value'=>$model->statusLabel(),
                    ],
                    'created_at',
                    [
                        'attribute'=>'is_deleted',
                        'value'=>function($data) {
                            return $data->isDeletedLabel();
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>
<?php Pjax::end(); ?>

