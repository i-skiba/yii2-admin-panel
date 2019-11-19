<?php

use yii\helpers\Html;

?>

<div class="flex-fill">
    <div class="text-center mb-3">
        <h1 class="error-title">
            <?= Html::encode($code) ?>
        </h1>
        <h5>
            <?= nl2br(Html::encode($message)) ?>
        </h5>
    </div>
    <div class="row">
        <div class="col-xl-4 offset-xl-4 col-md-8 offset-md-2">
            <div class="row">
                <div class="col-sm-12">
                    <a href="<?= (Yii::$app->request->referrer ?: Yii::$app->homeUrl);?>" class="btn btn-primary btn-block">
                        <i class="icon-home4 mr-2"></i> <?php echo Yii::t('yii2admin','Назад');?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>