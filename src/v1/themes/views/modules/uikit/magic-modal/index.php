<?php

/* @var $this \kamaelkz\yii2admin\v1\themes\components\view\View */

use yii\helpers\Url;
use kamaelkz\yii2admin\v1\widgets\formelements\magicmodalinput\MagicModalInput;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;

$this->setTitle(Yii::t('yii2admin', 'Магические модалки'));
$this->pushBreadcrumbs($this->title);
$this->viewHelper()->pushPageHeader(
    null,
    Yii::t('yii2admin', 'Форма создания'),
    'icon-windows2',
    [
        'class' => 'magic-modal-control',
        'data-url' => Url::to(['create']),
        'data-modal-size' => 'modal-full'
    ]
);
$this->viewHelper()->pushPageHeader(
    null,
    Yii::t('yii2admin', 'Элемент с ошибкой'),
    'icon-warning2',
    [   
        'class' => 'magic-modal-control',
        'data-url' => Url::to(['some/link/error']),
    ]
);
?>
<div class="card">
    <div class="card-body">
        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <?= Yii::t('yii2admin', 'Начинается магия друзья'); ?>
        </legend>
        <?php $form = ActiveForm::begin(['id' => 'uiikit-form']); ?>
            <?= MagicModalInput::widget([
                    'form' => $form,
                    'model' => $model,
                    'attribute' => 'text_input',
                    'label_attribute' => 'text_input',
                    'route' => Url::to(['create'])
            ]);?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
