<?php
    use kamaelkz\yii2admin\v1\widgets\ {
        notifications\alert\Alert,
        formelements\multiinput\MultiInput,
        formelements\editors\froala\FroalaEditor,
        formelements\uploader\CdnUploader,
        formelements\activeform\ActiveForm,
        formelements\Pjax,
        formelements\pickers\DatePicker,
        formelements\pickers\TimePicker
    };
    use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
    use kamaelkz\yii2cdnuploader\enum\StrategiesEnum;
    use yii\helpers\Html;
    use yii\widgets\MaskedInput;
    use kamaelkz\yii2admin\v1\modules\uikit\enums\UiikitEnum;

    $title = Yii::t('yii2admin', 'Виджеты');
    $this->setTitle($title);
    $this->pushBreadcrumbs($title);
?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">
            <?= Yii::t('yii2admin', 'Предупреждающие сообщения') ;?>
        </h5>
    </div>
    <div class="card-body">
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
            <div class="card-header header-elements-inline">
                <h5 class="card-title">
                    <?= Yii::t('yii2admin', 'Элементы формы') ;?>
                </h5>
            </div>
            <div class="card-body">
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
                                    'clientOptions' => [
                                        'attribution' => false,
                                        'heightMin' => 200,
                                        'toolbarSticky' => true,
                                        'toolbarInline'=> false,
                                        'theme' =>'royal', //optional: dark, red, gray, royal
                                        'language' => Yii::$app->language,
                                        'quickInsertTags' => [],
                                    ]
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