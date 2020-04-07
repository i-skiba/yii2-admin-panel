<?php
    use concepture\yii2logic\enum\StatusEnum;
    use concepture\yii2user\enum\UserRoleEnum;

    $is_superadmin = Yii::$app->getUser()->can(UserRoleEnum::SUPER_ADMIN);

?>
<div class="row">
    <?php if($is_superadmin) :?>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <?= $form->field($model,'id')->textInput();?>
        </div>
    <?php endif;?>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <?= $form->field($model,'name')->textInput();?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <?= $form
            ->field($model, 'status')
            ->dropDownList(StatusEnum::arrayList(), [
                'class' => 'form-control custom-select',
                'prompt' => ''
            ]);
        ?>
    </div>
</div>