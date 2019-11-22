<?php

    use kamaelkz\yii2admin\v1\modules\uikit\enum\UiikitEnum;

?>
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <?= $form->field($model,'id')->textInput();?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <?= $form
            ->field($model, 'dropdown')
            ->dropDownList(UiikitEnum::getDropdownList(), [
                'class' => 'form-control custom-select',
                'prompt' => ''
            ]);
        ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <?= $form
            ->field($model, 'dropdown_root')
            ->dropDownList(UiikitEnum::getDropdownList(), [
                'class' => 'form-control form-control-uniform active-form-refresh-control',
                'prompt' => ''
            ]);
        ?>
    </div>
    <?php if($model->dropdown_root == UiikitEnum::DEPEND_CHANGE_VALUE):?>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <?= $form
                ->field($model, 'dropdown_depend')
                ->dropDownList(UiikitEnum::getDropdownList(), [
                    'class' => 'form-control form-control-uniform active-form-refresh-control',
                    'prompt' => ''
                ]);
            ?>
        </div>
    <?php endif; ?>
    <?php if($model->dropdown_root == UiikitEnum::DEPEND_CHANGE_VALUE && $model->dropdown_depend > 0):?>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <?= $form
                ->field($model, 'dropdown_depend_2')
                ->dropDownList(UiikitEnum::getDropdownList(), [
                    'class' => 'form-control form-control-uniform',
                    'prompt' => ''
                ]);
            ?>
        </div>
    <?php endif; ?>
</div>