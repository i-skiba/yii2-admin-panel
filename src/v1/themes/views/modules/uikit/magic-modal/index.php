<?php

/* @var $this \kamaelkz\yii2admin\v1\themes\components\view\View */

use yii\helpers\Url;

$this->setTitle(Yii::t('yii2admin', 'Магические модалки'));
$this->pushBreadcrumbs($this->title);
$this->viewHelper()->pushPageHeader(
    null,
    Yii::t('yii2admin', 'Форма создания'),
    'icon-windows2',
    [
        'class' => 'magic-modal-control',
        'data-url' => Url::to(['create']),
        'data-modal-size' => 'modal-full'
    ]
);
$this->viewHelper()->pushPageHeader(
    null,
    Yii::t('yii2admin', 'Элемент с ошибкой'),
    'icon-warning2',
    [
        'class' => 'magic-modal-control',
        'data-url' => Url::to(['some/link/error']),
    ]
);
?>
будет что то точно
