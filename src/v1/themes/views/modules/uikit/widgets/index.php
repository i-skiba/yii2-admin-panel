<?php
    use yii\helpers\Html;
    use yii\widgets\MaskedInput;
    use kamaelkz\yii2admin\v1\widgets\ {
        notifications\alert\Alert,
        formelements\multiinput\MultiInput,
        formelements\editors\froala\FroalaEditor,
        formelements\activeform\ActiveForm,
        formelements\Pjax,
        formelements\pickers\DatePicker,
        formelements\pickers\TimePicker
    };

    use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
    use kamaelkz\yii2admin\v1\modules\uikit\enum\UiikitEnum;
    use kamaelkz\yii2cdnuploader\enum\StrategiesEnum;
    use kamaelkz\yii2cdnuploader\widgets\CdnUploader;
    use kamaelkz\yii2admin\v1\widgets\formelements\select2\Select2;
    use kamaelkz\yii2admin\v1\widgets\formelements\dynamicform\DynamicForm;

    $title = Yii::t('yii2admin', 'Виджеты');
    $this->setTitle($title);
    $this->pushBreadcrumbs($title);
?>
<div class="card">
    <div class="card-body">
        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <?= Yii::t('yii2admin', 'Предупреждающие сообщения');?>
        </legend>
        <?= Alert::widget([
            'type' => FlashAlertEnum::INFO,
            'message' => FlashAlertEnum::INFO,
        ]) ;?>
        <?= Alert::widget([
                'type' => FlashAlertEnum::SUCCESS,
                'message' => FlashAlertEnum::SUCCESS,
        ]) ;?>
        <?= Alert::widget([
            'type' => FlashAlertEnum::ERROR,
            'message' => FlashAlertEnum::ERROR,
        ]) ;?>
        <?= Alert::widget([
            'type' => FlashAlertEnum::WARNING,
            'message' => FlashAlertEnum::WARNING,
        ]) ;?>
        <?= Alert::widget([
            'type' => FlashAlertEnum::PRIMARY,
            'message' => FlashAlertEnum::PRIMARY,
        ]) ;?>
    </div>
</div>
<?php Pjax::begin(['formSelector' => '#uiikit-form']); ?>
    <?php $form = ActiveForm::begin(['id' => 'uiikit-form']); ?>
        <div class="card">
            <div class="card-body">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <?= Yii::t('yii2admin', 'Элементы формы') ;?>
                </legend>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form
                                ->field($uikitForm, 'mask')
                                ->widget(MaskedInput::class, [
                                    'mask' => '999-999-99-99',
                                ]);
                        ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form->field($uikitForm, 'text_input')->textInput(); ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form
                                ->field($uikitForm,'date_picker', [
                                    'template' => '
                                            {label}
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="btn bg-pink">
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
                                ->field($uikitForm,'time_picker', [
                                    'template' => '
                                            {label}
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="btn bg-pink">
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
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form
                                ->field($uikitForm, 'editor')
                                ->widget(FroalaEditor::class, [
                                    'model' => $uikitForm,
                                    'attribute' => 'editor',
                                ]);
                        ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form->field($uikitForm, 'text_area')->textarea(); ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form
                            ->field($uikitForm, 'dropdown')
                            ->dropDownList($dropdownList, [
                                'class' => 'form-control custom-select',
                                'prompt' => ''
                            ]);
                        ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form
                            ->field($uikitForm, 'dropdown_root')
                            ->dropDownList($dropdownList, [
                                'class' => 'form-control form-control-uniform active-form-refresh-control',
                                'prompt' => ''
                            ]);
                        ?>
                    </div>
                    <?php if($uikitForm->dropdown_root == UiikitEnum::DEPEND_CHANGE_VALUE):?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <?= $form
                                ->field($uikitForm, 'dropdown_depend')
                                ->dropDownList($dropdownList, [
                                    'class' => 'form-control form-control-uniform active-form-refresh-control',
                                    'prompt' => ''
                                ]);
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if($uikitForm->dropdown_root == UiikitEnum::DEPEND_CHANGE_VALUE && $uikitForm->dropdown_depend > 0):?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <?= $form
                                ->field($uikitForm, 'dropdown_depend_2')
                                ->dropDownList($dropdownList, [
                                    'class' => 'form-control form-control-uniform',
                                    'prompt' => ''
                                ]);
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?= $form
                                ->field($uikitForm, 'image')
                                ->widget(CdnUploader::class, [
                                    'model' => $uikitForm,
                                    'attribute' => 'image',
                                    'strategy' => StrategiesEnum::BY_REQUEST,
                                    'resizeBigger' => false,
                                    'width' => 313,
                                    'height' => 235,
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
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <?= $form
                                    ->field($uikitForm, 'checkbox_standart', [
                                        'template' => '
                                        <div class="form-check form-check-inline mt-2">
                                            {input}
                                        </div>
                                        {error}
                                    '
                                    ])
                                    ->checkbox(
                                        [
                                            'class' => 'form-check-input-styled-custom',
                                            'labelOptions' => ['class' => 'form-check-label control-label']
                                        ],
                                        true
                                    );
                                ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <?= $form
                                    ->field($uikitForm, 'checkbox_switch', [
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
                        <?=
                            MultiInput::widget([
                                'model' => $uikitForm,
                                'attribute' => 'multiInput',
                                'limit' => 3,
                                'columnClass' => 'col-md-4',
                                'buttonClass' => 'bg-pink',
                            ]);
                        ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form
                                ->field($uikitForm, 'checkboxList', [
                                    'template' => '
                                            {label}
                                            {input}
                                        <div class="row">
                                            <div class="col-md-12">
                                            {error}
                                            </div>
                                        </div>',
                                    ]
                                )->checkboxList(
                                    $checkboxList ,
                                    [
                                        'item' => function($index, $label, $name, $checked, $value) use($uikitForm) {
                                            return "<div class='form-check col-md-4'>
                                                        <label class='form-check-label'>
                                                                " . Html::checkbox($name, $checked , ['value' => $value , 'class' => 'form-check-input-styled-custom']) . "
                                                                {$label}
                                                        </label>
                                                    </div>";

                                        },
                                        'class' => 'row ml-0'
                                    ]
                                );
                        ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?= $form
                            ->field($uikitForm, 'radio', [])
                            ->radioList(
                                $checkboxList ,
                                [
                                    'item' => function($index, $label, $name, $checked, $value) use($uikitForm) {
                                        if($index === 0 && ! $uikitForm->radio) {
                                            $checked = true;
                                        }

                                        return "<div class='form-check col-md-4'>
                                                    <label class='form-check-label'>
                                                        " .  Html::radio($name, $checked, ['value' => $value, 'class' => 'form-check-input-styled-custom']) . "
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
                    <?= $uikitForm->getAttributeLabel('select2') ?>
                </legend>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form
                            ->field($uikitForm, 'select2')
                            ->widget(Select2::class, [
                                'form' => $form,
                                'data' => $dropdownList,
                                'options' => [
                                    'minimumResultsForSearch' => 'Infinity',
                                ],
                            ])->label(Yii::t('yii2admin', 'Базовый select'));
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form
                            ->field($uikitForm, 'select2')
                            ->widget(Select2::class, [
                                'form' => $form,
                                'data' => $dropdownList,
                                'options' => [
                                    'multiple' => true,
                                ],
                            ])->label(Yii::t('yii2admin', 'Мульти select'));
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form
                            ->field($uikitForm, 'select2')
                            ->widget(Select2::class, [
                                'form' => $form,
                                'data' => $dropdownList,
                                'options' => [
                                    'prompt' => Yii::t('yii2admin', 'Выберите элемент'),
                                    'containerCssClass' => 'bg-pink',
                                    'dropdownCssClass' => 'bg-pink',
                                ],
                            ])->label(Yii::t('yii2admin', 'Плейсхолдер и цвет бэкграунда'));
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form
                            ->field($uikitForm, 'select2')
                            ->widget(Select2::class, [
                                'form' => $form,
                                'data' => $dropdownList,
                                'options' => [
                                    'width' => 400,
                                ],
                            ])->label(Yii::t('yii2admin', 'Фиксированная ширина'));
                        ?>
                    </div>
                </div>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <?= Yii::t('yii2admin', 'Коллекция') ;?>
                </legend>
                <?= DynamicForm::widget([
                    'limit' => 3, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'form' => $form,
                    'models' => [
                        new \kamaelkz\yii2admin\v1\modules\uikit\forms\CollectionForm()
                    ],
                    'dragAndDrop' => true,
                    'formId' => 'uiikit-form',
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
        <div class="card">
            <div class="card-body">
                <?=  Html::submitButton(
                    '<i class="icon-floppy-disks"></i> ' . Yii::t('yii2admin', 'Сохранить'),
                    [
                        'class' => 'btn bg-success'
                    ]
                ); ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>