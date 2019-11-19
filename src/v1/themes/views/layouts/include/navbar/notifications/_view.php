<?php
    use yii\helpers\Url;
    use common\helpers\ConstHelper;
    
    $url = $model->getUrl();
    if(! $url) {
        $url = Url::toRoute(['/notice/admin-notification/view', 'id' => $model->id]);
    }
    $readUrl = Url::toRoute(['/notice/admin-notification/change-status', 'id' => $model->id, 'status' => ConstHelper::STATUS_ACTIVE]);
?>
<div class="media-body">
    <a data-read-url="<?= $readUrl?>" href="<?= $url;?> " class="media-heading admin-notice-read" target="_blank">
            <span class="text-semibold">
                <?= $model->getTitle();?>
            </span>
            <span class="media-annotation pull-right">
                <?= Yii::$app->formatter->asDateTime($model->create_ts);?>
            </span>
        </a>
        <span class="text-muted">
            <?= $model->getMessage();?>
        </span>
</div>
