<?php

//use common\enum\MenuEnum;
//use concepture\yii2logic\enum\StatusEnum;
?>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <?= $form->field($model,'id')->textInput();?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <?= $form->field($model,'action')->textInput();?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <?= $form->field($model,'model_pk')->textInput();?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <?= $form->field($model,'field')->textInput();?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <?= $form->field($model,'created_at')->textInput();?>
    </div>
</div>