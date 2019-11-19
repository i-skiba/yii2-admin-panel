<?php
    use yii\helpers\Html;
?>
<?= 
    $form->field($model, $attribute, [
        'template' => '
            {label}
            <div style="cursor:pointer;" class="input-group magic-modal-control"  data-url="' . $route . '" data-callback="' . $callback . '">
                <div class="form-control hidden-label">' 
                    . $model->{$label_attribute}  
                    . Html::hiddenInput($model->formName() . "[{$label_attribute}]", $model->{$label_attribute}) . '
                </div>
                <span class="input-group-addon bg-primary">
                    <i class="' . $icon . '"></i>
                </span>
                {input}
            </div>
            {error}
        '
    ])->hiddenInput(); 
?>