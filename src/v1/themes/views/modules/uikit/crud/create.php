<?php

/* @var $this \kamaelkz\yii2admin\v1\themes\components\view\View */

$this->setTitle(Yii::t('yii2admin', 'Новая запись'));
$this->pushBreadcrumbs(['label' => Yii::t('yii2admin', 'CRUD'), 'url' => ['index']]);
$this->pushBreadcrumbs($this->title);
$this->viewHelper()->pushPageHeader(['index'], Yii::t('yii2admin', 'Список'),'icon-list');

?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
