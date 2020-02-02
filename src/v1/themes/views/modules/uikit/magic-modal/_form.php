<?php
    use yii\helpers\Html;
    use kamaelkz\yii2admin\v1\widgets\ {
        formelements\editors\froala\FroalaEditor,
        formelements\activeform\ActiveForm,
    };

    use kamaelkz\yii2cdnuploader\enum\StrategiesEnum;
    use kamaelkz\yii2cdnuploader\widgets\CdnUploader;
    use kamaelkz\yii2admin\v1\modules\uikit\enum\UiikitEnum;
    use kamaelkz\yii2admin\v1\widgets\formelements\dynamicform\DynamicForm;
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
                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            <i class="icon-equalizer2  2 mr-2"></i>
                            <?= Yii::t('yii2admin', 'Коллекция');?>
                        </legend>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-left">
                            <?= DynamicForm::widget([
                                'limit' => 3, // the maximum times, an element can be cloned (default 999)
                                'min' => 1, // 0 or 1 (default 1)
                                'form' => $form,
                                'models' => [
                                    new \kamaelkz\yii2admin\v1\modules\uikit\forms\CollectionForm()
                                ],
                                'dragAndDrop' => true,
                                'formId' => 'magic-modal-form',
                                'attributes' => [
                                    'text_input' => Html::FIELD_TEXT_INPUT,
                                    'dropdown' => [
                                        'type' => Html::FIELD_DROPDOWN,
                                        'params' => [
                                            UiikitEnum::getDropdownList(),
                                            [
                                                'class' => 'form-control custom-select',
                                                'prompt' => ''
                                            ]
                                        ]
                                    ],
                                    'image' => function ($collection, $form, $key, $value) {
                                        return CdnUploader::widget([
                                            'small' => true,
                                            'name' => "{$collection->formName()}[$key][image]",
                                            'value' => $value,
                                            'strategy' => StrategiesEnum::BY_REQUEST,
                                            'resizeBigger' => false,
                                            'buttonIconClass' => 'icon-cloud-upload2',
                                            'width' => 313,
                                            'height' => 235,
                                            'options' => [
                                                'plugin-options' => [
                                                    # todo: похоже не пашет
                                                    'maxFileSize' => 2000000,
                                                ]
                                            ]
                                        ]);
                                    }
                                ]
                            ]); ?>
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
