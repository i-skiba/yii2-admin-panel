<?php

/* @var $this \kamaelkz\yii2admin\v1\themes\components\view\View */

$this->setTitle(Yii::t('yii2admin', 'Редактирование записи'));
$this->pushBreadcrumbs(['label' => Yii::t('yii2admin', 'Интерфейс'), 'url' => ['index']]);
$this->pushBreadcrumbs($this->title);
$this->viewHelper()->pushPageHeader();
$this->viewHelper()->pushPageHeader(['view', 'id' => $model->id], Yii::t('yii2admin', 'Просмотр'),'icon-file-eye2');
$this->viewHelper()->pushPageHeader(['index'], Yii::t('yii2admin', 'Список'),'icon-list');

?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
