<?php
    use yii\helpers\Html;
?>
<table class="table table-bordered table-striped dynamic-form-items">
    <thead>
        <?= $header;?>
    </thead>
    <?= Html::tag('tbody', $body, $dragAndDropOptions);?>
</table>
<?php if ($editable): ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 text-left">
            <button type="button" class="btn btn-primary btn-labeled btn-labeled-left mt-3 dynamic-form-add-item" data-message="<?= Yii::t('yii2admin', 'Превышено максимальное количество элементов');?>">
                <b>
                    <i class="icon-plus-circle2 "></i>
                </b>
                <?= Yii::t('yii2admin', 'Добавить');?>
            </button>
        </div>
    </div>
<?php endif; ?>