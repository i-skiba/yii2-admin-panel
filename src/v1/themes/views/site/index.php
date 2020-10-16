<?php
    use yii\helpers\Url;

    $this->setTitle(Yii::t('yii2admin', 'Административная панель'));
?>
<div class="row">
    <?php
    echo Yii::t('yii2admin', 'Пользователи');
    echo Yii::t('common', 'Пользователи');
    echo Yii::t('yii2admin', 'Отзывы');
    echo Yii::t('common', 'Отзывы');
    ?>
    <?= \kamaelkz\yii2admin\v1\widgets\navigation\dashboard\Dashboard::widget();?>
</div>


