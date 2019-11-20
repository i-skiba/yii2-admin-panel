<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('backend', "Смена пароля");
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= \Yii::t('backend', "Введите новый пароль: "); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'validation')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(\Yii::t('backend', "Сменить"), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
