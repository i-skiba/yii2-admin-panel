<?php

use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;
use concepture\yii2handbook\enum\SettingsTypeEnum;
use kamaelkz\yii2admin\v1\widgets\formelements\editors\froala\FroalaEditor;

$this->setTitle(Yii::t('yii2admin', 'Редактирование атрибута'));
?>

<?php Pjax::begin(['formSelector' => '#update-column-form']); ?>

<?php $form = ActiveForm::begin(['id' => 'update-column-form']); ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <?php if ($type == SettingsTypeEnum::TEXT) : ?>
                    <?= $form->field($model, $column)->textInput(['maxlength' => true])->label($originModel->getAttributeLabel($column)) ?>
                <?php endif;?>

                <?php if ($type == SettingsTypeEnum::TEXT_AREA) : ?>
                    <?= $form->field($model, $column)->textarea()->label($originModel->getAttributeLabel($column)); ?>
                <?php endif;?>

                <?php if ($type == SettingsTypeEnum::TEXT_EDITOR) : ?>
                    <?= $form
                        ->field($model, $column)
                        ->widget(FroalaEditor::class, [
                            'model' => $model,
                            'attribute' => $column,
                            'clientOptions' => [
                                'attribution' => false,
                                'heightMin' => 200,
                                'toolbarSticky' => true,
                                'toolbarInline'=> false,
                                'theme' =>'royal', //optional: dark, red, gray, royal
                                'language' => Yii::$app->language,
                                'quickInsertTags' => [],
                            ]
                        ])->label($originModel->getAttributeLabel($column))
                    ?>
                <?php endif;?>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                <?=  Html::submitButton(
                    '<b><i class="icon-checkmark3"></i></b>' . Yii::t('yii2admin', 'Сохранить'),
                    [
                        'class' => 'btn bg-success btn-labeled btn-labeled-left ml-1'
                    ]
                ); ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
