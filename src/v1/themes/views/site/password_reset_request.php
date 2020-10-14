<?php

use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;

$this->title = \Yii::t('yii2admin', "Восстановление пароля");
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= \Yii::t('yii2admin', "Для восстановления пароля заполните форму: "); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'identity')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(\Yii::t('yii2admin', "Принять"), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
