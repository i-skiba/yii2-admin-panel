<?php
    use yii\helpers\Html;
?>

<div class="form-group multiinput-box row <?= ($model->isAttributeRequired($attribute) ? 'required' : null) ?>" data-limit='<?= $limit;?>'>
    <?php for($i = 0; $i < $elementCount; $i ++) :?>
    <div class="<?= $columnClass;?> multiinput-box-element">
        <div class="form-group">
            <?= Html::activeLabel($model, $attribute, ['class' => 'control-label']);?>
            <div class="input-group">
                <?= Html::activeTextInput($model, "{$attribute}[$i]", ['class' => 'form-control']);?>
                <?php if($i == 0) :?>
                    <span class="input-add input-group-append">
                        <span class="btn <?= $buttonClass;?>">
                            <i class="icon-plus-circle2"></i>
                        </span>
                    </span>
                <?php endif;?>
                <span class="input-remove input-group-append <?= $i == 0 ? 'd-none' : null;?>">
                    <span class="btn <?= $buttonClass;?>">
                        <i class="icon-minus-circle2"></i>
                    </span>
                </span>
            </div>
            <?php if($i == 0) :?>
                <?= Html::error($model, $attribute, ['class' => 'text-danger form-text']);?>
            <?php endif;?>
        </div>
    </div>
    <?php endfor;?>
</div>