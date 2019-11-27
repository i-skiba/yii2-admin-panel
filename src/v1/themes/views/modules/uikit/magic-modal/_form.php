<?php
    use yii\helpers\Html;
    use kamaelkz\yii2admin\v1\widgets\ {
        formelements\editors\froala\FroalaEditor,
        formelements\activeform\ActiveForm,
    };

    use kamaelkz\yii2cdnuploader\enum\StrategiesEnum;
    use kamaelkz\yii2cdnuploader\widgets\CdnUploader;
?>

<?php $form = ActiveForm::begin(['id' => 'magic-modal-form']); ?>
    <div class="card">
        <div class="card-body text-right">
            <?=  Html::submitButton(
                '<b><i class="icon-checkmark3"></i></b>' . Yii::t('yii2admin', 'Сохранить'),
                [
                    'class' => 'btn bg-success btn-labeled btn-labeled-left ml-1'
                ]
            ); ?>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?= $form->field($model, 'text_input')->textInput(); ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <?= $form
                        ->field($model, 'image')
                        ->widget(CdnUploader::class, [
                            'model' => $model,
                            'attribute' => 'image',
                            'strategy' => StrategiesEnum::BY_REQUEST,
                            'resizeBigger' => false,
                            'width' => 313,
                            'height' => 235,
                            'options' => [
                                'plugin-options' => [
                                    # todo: похоже не пашет
                                    'maxFileSize' => 2000000,
                                ]
                            ],
                            'clientEvents' => [
                                'fileuploaddone' => new \yii\web\JsExpression('function(e, data) {
                                            console.log(e);
                                        }'),
                                'fileuploadfail' => new \yii\web\JsExpression('function(e, data) {
                                            console.log(e);
                                        }'),
                            ],
                        ])
                        ->error(false)
                        ->hint(false);
                    ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <?= $form
                                ->field($model, 'checkbox_standart', [
                                    'template' => '
                                        <div class="form-check form-check-inline mt-2">
                                            {input}
                                        </div>
                                        {error}
                                    '
                                ])
                                ->checkbox(
                                    [
                                        'class' => 'form-check-input-styled-primary',
                                        'labelOptions' => ['class' => 'form-check-label control-label']
                                    ],
                                    true
                                );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body text-right">
            <?=  Html::submitButton(
                '<b><i class="icon-checkmark3"></i></b>' . Yii::t('yii2admin', 'Сохранить'),
                [
                    'class' => 'btn bg-success btn-labeled btn-labeled-left ml-1'
                ]
            ); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
