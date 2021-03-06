<?php

use yii\helpers\Url;
use concepture\yii2user\enum\UserRoleEnum;

$this->setTitle(Yii::t('yii2admin', 'Редактирование'));
$this->pushBreadcrumbs(['label' => $model::label(), 'url' => ['index']]);
$this->pushBreadcrumbs($this->title);
$this->viewHelper()->pushPageHeader(['index'], $model::label(),'icon-list');
?>

<?= $this->render('_form', [
    'model' => $model,
    'originModel' => $originModel
]) ?>
