<?php
    use yii\helpers\Url;

    $this->setTitle(Yii::t('yii2admin', 'Административная панель'));
?>
<div class="row">
    <?= \kamaelkz\yii2admin\v1\widgets\navigation\dashboard\Dashboard::widget();?>
</div>


