<?php
    use yii\helpers\Html;
    use yii\widgets\MaskedInput;
    use kamaelkz\yii2admin\v1\widgets\ {
        formelements\multiinput\MultiInput,
        formelements\editors\froala\FroalaEditor,
        formelements\activeform\ActiveForm,
        formelements\Pjax,
        formelements\pickers\DatePicker,
        formelements\pickers\TimePicker
    };

    use kamaelkz\yii2admin\v1\modules\uikit\enum\UiikitEnum;
    use kamaelkz\yii2cdnuploader\enum\StrategiesEnum;
    use kamaelkz\yii2cdnuploader\widgets\CdnUploader;
    use kamaelkz\yii2cdnuploader\widgets\Uploader;
    use kamaelkz\yii2admin\v1\helpers\RequestHelper;
    use wbraganca\dynamicform\DynamicFormWidget;

    $saveRedirectButton = Html::saveRedirectButton();
    $saveButton = Html::saveButton();
?>
<?php Pjax::begin(['formSelector' => '#uiikit-form']); ?>
    <?php $form = ActiveForm::begin(['id' => 'uiikit-form']); ?>
        <div class="card">
            <div class="card-body text-right">
                <?= $saveRedirectButton?>
                <?= $saveButton?>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-file-empty  mr-2"></i>
                    <?= Yii::t('yii2admin', 'Однострочные текстовые поля');?>
                </legend>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form
                            ->field($model, 'mask')
                            ->widget(MaskedInput::class, [
                                'mask' => '999-999-99-99',
                            ]);
                        ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form->field($model, 'text_input')->textInput(); ?>
                    </div>
                </div>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-watch2 mr-2"></i>
                    <?= Yii::t('yii2admin', 'Дата / время');?>
                </legend>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form
                            ->field($model,'date_picker', [
                                'template' => '
                                                {label}
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="btn bg-primary">
                                                            <i class="icon-calendar2"></i>
                                                        </span>
                                                    </span>
                                                    {input}
                                                </div>
                                                {error}'
                            ])
                            ->widget(DatePicker::class)
                        ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form
                            ->field($model,'time_picker', [
                                'template' => '
                                                {label}
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="btn bg-primary">
                                                            <i class="icon-alarm-add"></i>
                                                        </span>
                                                    </span>
                                                    {input}
                                                </div>
                                                {error}'
                            ])
                            ->widget(TimePicker::class)
                        ?>
                    </div>
                </div>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-file-text2 mr-2"></i>
                    <?= Yii::t('yii2admin', 'Многострочные текстовые поля');?>
                </legend>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form
                            ->field($model, 'editor')
                            ->widget(FroalaEditor::class, [
                                'model' => $model,
                                'attribute' => 'editor',
                            ]);
                        ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form->field($model, 'text_area')->textarea(); ?>
                    </div>
                </div>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-chevron-down 2 mr-2"></i>
                    <?= Yii::t('yii2admin', 'Выпадающие списки');?>
                </legend>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form
                            ->field($model, 'dropdown')
                            ->dropDownList(UiikitEnum::getDropdownList(), [
                                'class' => 'form-control custom-select',
                                'prompt' => ''
                            ]);
                        ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <?= $form
                                    ->field($model, 'dropdown_root')
                                    ->dropDownList(UiikitEnum::getDropdownList(), [
                                        'class' => 'form-control form-control-uniform active-form-refresh-control',
                                        'prompt' => ''
                                    ]);
                                ?>
                            </div>
                            <?php if($model->dropdown_root == UiikitEnum::DEPEND_CHANGE_VALUE):?>
                                <div class="col-lg-6 col-md-6 col-sm-12">
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
                                <div class="col-lg-6 col-md-6 col-sm-12">
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
                    </div>
                </div>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-file-upload 2 mr-2"></i>
                    <?= Yii::t('yii2admin', 'Загрузка изображений');?>
                </legend>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form
                            ->field($model, 'image')
                            ->widget(CdnUploader::class, [
                                'model' => $model,
                                'attribute' => 'image',
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
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form
                            ->field($model, 'image_local')
                            ->widget(Uploader::class, [
                                'model' => $model,
                                'attribute' => 'image_local',
                                'buttonWrapClass' => 'bg-pink',
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
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-equalizer2  2 mr-2"></i>
                    <?= Yii::t('yii2admin', 'Чекбоксы / радио кнопки');?>
                </legend>
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
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <?= $form
                                    ->field($model, 'checkbox_switch', [
                                        'template' => '
                                                <div class="form-check form-check-switch form-check-switch-left">
                                                    {input}
                                                </div>
                                                {error}
                                            '
                                    ])
                                    ->checkbox(
                                        [
                                            'class' => 'form-check-input form-check-input-switch active-form-refresh-control',
                                            'data-on-text' => "<i class='icon-checkmark3'></i>",
                                            'data-off-text' => "<i class=' icon-cross2'></i>",
                                            'data-on-color' => "success",
                                            'labelOptions' => ['class' => 'form-check-label control-label']
                                        ],
                                        true
                                    );
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form
                            ->field($model, 'radio', [])
                            ->radioList(
                                UiikitEnum::getDropdownList() ,
                                [
                                    'item' => function($index, $label, $name, $checked, $value) use($model) {
                                        if($index === 0 && ! $model->radio) {
                                            $checked = true;
                                        }

                                        return "<div class='form-check col-md-4'>
                                                    <label class='form-check-label'>
                                                        " .  Html::radio($name, $checked, ['value' => $value, 'class' => 'form-check-input-styled-primary']) . "
                                                        {$label}
                                                    </label>
                                                </div>";
                                    },
                                    'class' => 'row ml-0'
                                ]
                            )
                        ?>
                    </div>
                </div>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-equalizer2  2 mr-2"></i>
                    <?= Yii::t('yii2admin', 'Коллекция');?>
                </legend>
                    <?php
                        $collections = [new \kamaelkz\yii2admin\v1\modules\uikit\forms\CollectionForm()];
                    ?>
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.dynamic-form-items', // required: css class selector
                        'widgetItem' => '.dynamic-form-item', // required: css class
                        'limit' => 4, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.dynamic-form-add-item', // css class
                        'deleteButton' => '.dynamic-form-remove-item', // css class
                        'model' => reset($collections),
                        'formId' => 'uiikit-form',
                        'formFields' => [
                            'text_input',
                            'text_area',
                            'image',
                        ],
                    ]); ?>
                    <div class="dynamic-form-items row">
                        <?php foreach ($collections as $key => $collection) :?>
                            <div class="col-lg-12 col-md-12 col-sm-12 dynamic-form-item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start flex-nowrap">
                                            <h6 class="no-margin">
                                                <?= "Элемент";?>
                                            </h6>
                                            <div class="list-icons list-icons-extended ml-auto">
                                                <a href="#" class="list-icons-item file-delete dynamic-form-remove-item">
                                                    <i class="icon-bin top-0"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <?= $form->field($collection, "[$key]text_input")->textInput(); ?>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <?= $form
                                                    ->field($collection, "[$key]dropdown")
                                                    ->dropDownList(UiikitEnum::getDropdownList(), [
                                                        'class' => 'form-control custom-select',
                                                        'prompt' => ''
                                                    ]);
                                                ?>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <?= $form
                                                    ->field($collection, 'image')
                                                    ->widget(CdnUploader::class, [
                                                        'model' => $collection,
                                                        'attribute' => "[$key]image",
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
                                                    ])
                                                    ->error(false)
                                                    ->hint(false);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12 text-right">
                            <?= Html::button(
                                '<b><i class="icon-plus-circle2"></i></b>' . Yii::t('yii2admin', 'Добавить'),
                                [
                                    'class' => 'btn bg-primary btn-labeled btn-labeled-left ml-1 dynamic-form-add-item'
                                ]
                            );?>
                        </div>
                    </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-right">
                <?= $saveRedirectButton?>
                <?= $saveButton?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>