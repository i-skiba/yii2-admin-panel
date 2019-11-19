<?php

use yii\helpers\Html;

?>
<div class="cdn-upload-wrapper">
    <div>
        <div class="btn <?= $buttonWrapClass;?> btn-labeled btn-labeled-left btn-file">
            <b>
                <i class="<?= $buttonIconClass;?>"></i>
            </b>
            <?= Yii::t('yii2admin', 'Выберите файл');?>
            <?= $input ?>
            <?= $hidden ?>
        </div>
    </div>
    <?php if(! empty($hint)) :?>
        <div class="mt-1">
           <span class="text-muted">
                <?= $hint;?>
           </span>
        </div>
    <?php else: ?>
        <?= Html::activeHint($model, $attribute, ['class' => 'text-muted mt-1']);?>
    <?php endif; ?>
    <?= Html::error($model, $attribute, ['class' => 'text-danger form-text']);?>
    <div class="">
        <div class="progress mt-2 d-none">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" style="width: 0%;">
                <span class="">0%</span>
            </div>
        </div>
    </div>
    <div class="card file-info <?= (! $pojo->path) ? 'd-none' : null;?> mt-2">
        <div class="card-body">
            <div class="d-flex align-items-start flex-nowrap">
                <div>
                    <div class="font-weight-semibold mr-2 file-name">
                        <?php if($pojo->path):?>
                            <?= $pojo->path;?>
                        <?php endif;?>
                    </div>
                    <span class="font-size-sm text-muted">
                        <?= Yii::t('yii2admin', 'Размер');?>:
                        <span class="file-size">
                            <?php if($pojo->size):?>
                                <?= $pojo->size;?>
                            <?php endif;?>
                        </span>
                    </span>
                </div>

                <div class="list-icons list-icons-extended ml-auto">
                    <a href="#" class="list-icons-item file-delete">
                        <i class="icon-bin top-0"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-img-actions mx-1 mb-1 file-display">
            <?php if($pojo->path):?>
                <?php
                    $options = ['class' => 'card-img img-fluid'];
                    if($pojo->width && $pojo->height) {
                        $options['style'] = "width:{$pojo->width}; height:{$pojo->height}";
                    }
                ?>
                <?= Html::img(Yii::$app->cdnService->path($pojo->path), $options);?>
            <?php endif;?>
        </div>
    </div>
</div>