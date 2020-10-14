<?php

use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;

$this->title = \Yii::t('yii2admin', "Смена пароля");
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= \Yii::t('yii2admin', "Введите новый пароль: "); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'validation')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(\Yii::t('yii2admin', "Сменить"), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
