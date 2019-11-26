<?php
    use yii\helpers\Url;

    $this->setTitle(Yii::t('yii2admin', 'Административная панель'));
?>

<div>
    <a href="#" class="magic-modal-control" data-url="<?= Url::to(['/some/link']);?>" data-modal-size="modal-full">
        <?= Yii::t('yii2admin', 'Ошибка 404');?>
    </a>
</div>
<div>
    <a href="#" class="magic-modal-control" data-url="<?= Url::to(['/uikit/magic-modal/create']);?>" data-modal-size="modal-full">
        <?= Yii::t('yii2admin', 'Создать через магическую модалку');?>
    </a>
</div>