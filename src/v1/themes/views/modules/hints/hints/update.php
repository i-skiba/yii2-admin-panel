<?php

use concepture\yii2user\enum\UserRoleEnum;

$this->setTitle(Yii::t('yii2admin', 'Редактирование'));
$this->pushBreadcrumbs(['label' => $model::label(), 'url' => ['index']]);
$this->pushBreadcrumbs($this->title);
if(Yii::$app->getUser()->can(UserRoleEnum::SUPER_ADMIN)) {
    $this->viewHelper()->pushPageHeader();
}

$this->viewHelper()->pushPageHeader(['view', 'id' => $originModel->id], Yii::t('yii2admin', 'Просмотр'),'icon-file-eye2');
$this->viewHelper()->pushPageHeader(['index'], $model::label(),'icon-list');
?>

<?= $this->render('_form', [
    'model' => $model,
    'originModel' => $originModel
]) ?>
