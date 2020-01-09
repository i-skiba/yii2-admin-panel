<div class="alert alert-<?= $type;?> alert-styled-left alert-arrow-left alert-bordered ">
    <button type="button" class="close" data-dismiss="alert">
        <span>×</span>
        <span class="sr-only">
            <?= Yii::t('yii2admin','Закрыть');?>
        </span>
    </button>
    <?= $message;?>
</div>