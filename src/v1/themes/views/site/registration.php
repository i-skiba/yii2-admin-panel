<?php

use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;
use yii\web\View;

$this->title = \Yii::t('backend', "Регистрация");
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= \Yii::t('backend', "Для авторизации заполните форму: "); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>

            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'identity')->textInput() ?>
            <?= $form->field($model, 'validation')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton(\Yii::t('backend', "Зарегистрироваться"), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>