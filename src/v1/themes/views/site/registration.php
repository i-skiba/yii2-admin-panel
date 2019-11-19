<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \concepture\user\forms\SignUpForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
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