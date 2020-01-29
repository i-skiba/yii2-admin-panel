<?php
    use yii\helpers\Html;
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 text-left">
        <table class="table table-bordered table-striped dynamic-form-items">
            <thead>
            <tr>
                <td></td>
                <?php foreach ($attributes as $attribute => $settings) :?>
                    <td class="text-center">
                        <?= $model->getAttributeLabel($attribute);?>
                    </td>
                <?php endforeach; ?>
            <tr>
            </thead>
            <tbody>
            <?php foreach ($collections as $key => $collection) :?>
                <tr class="dynamic-form-item">
                    <td class="text-center" style="min-width: 5%;">
                        <button type="button" class="btn btn-primary btn-icon dynamic-form-remove-item">
                            <i class="icon-minus-circle2 "></i>
                        </button>
                    </td>
                    <?php foreach ($attributes as $attribute => $settings) :?>
                        <?php
                            list($fieldType, $fieldParams) = array_values($settings);
                        ?>
                        <td class="text-center">
                            <?
                                $value = $collections[$key][$attribute] ?? null;
                                if($fieldType === Html::FIELD_WIDGET) {
                                    echo call_user_func($fieldParams, $collection, $key, $value);
                                } else {
                                    $instance = $form->field($collection, "[$key]{$attribute}")->label(false);
                                    echo call_user_func_array(
                                        [$instance, $fieldType],
                                        ! is_callable($fieldParams)
                                            ? $fieldParams
                                            : call_user_func($fieldParams, $collection, $key,  $value)
                                    );
                                }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach;?>
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