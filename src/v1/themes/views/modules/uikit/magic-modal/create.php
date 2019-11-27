<?php
    $this->setTitle(Yii::t('yii2admin', 'Магическая модалка форма'));
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
