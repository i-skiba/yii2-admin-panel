<?php
    use yii\helpers\Html;
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 text-left">
        <table class="table table-bordered table-striped dynamic-form-items">
            <thead>
                <?= $header;?>
            </thead>
            <tbody class="<?= $dragAndDrop ? 'dnd-grid-view' : null;?>" data-without-request="">
                <?= $body;?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 text-left">
        <button type="button" class="btn btn-primary btn-labeled btn-labeled-left mt-3 dynamic-form-add-item">
            <b>
                <i class="icon-plus-circle2 "></i>
            </b>
            <?= Yii::t('yii2admin', 'Добавить');?>
        </button>
    </div>
</div>