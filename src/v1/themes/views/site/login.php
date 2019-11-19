<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \concepture\user\forms\SignInForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('backend', "Авторизация");
?>
<?php
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [
            'class' => 'login-form'
        ],
        'fieldConfig' => [
            'options' => [
                'class' => 'form-group form-group-feedback form-group-feedback-left'
            ],
            'errorOptions' => [
                'class' => 'validation-error-label'
            ],
            'inputOptions' => [
                'class' => 'form-control',
            ]
        ]
    ]);
?>
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                <h5 class="mb-0">
                    <?= \Yii::t(yii2admin, "Авторизация");?>
                </h5>
                <span class="d-block text-muted">
                    <?= Yii::t(yii2admin,'Введите свои учетные данные ниже');?>
                </span>
            </div>
            <?= $form
                    ->field($model,'identity' ,[
                    'template' => '
                            {input}
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                            {error}'
                    ])
                    ->textInput([
                        'placeholder' => $model->getAttributeLabel('identity')
                    ])
            ?>
            <?= $form
                    ->field($model,'validation' ,[
                        'template' => '
                                {input}
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                                {error}',
                    ])
                    ->passwordInput([
                        'placeholder' => $model->getAttributeLabel('validation')
                    ])
            ?>
            <div class="form-group d-flex align-items-center">
                <?= $form
                        ->field($model, 'rememberMe', [
                            'template' => '
                                    {beginLabel}
                                    {input}
                                    {labelTitle}
                                    {endLabel}',
                            'options' => [
                                'class' => 'form-check mb-0',
                            ],
                        ])
                        ->checkbox(
                            [
                                'class' => 'form-input-styled',
                                'checked' => '',
                                'data-fouc' => '',
    //                                'uncheck' => false
                            ],
                            false
                        )
                        ->label(null, ['class' => 'form-check-label'])
                        ->error(false)
                ?>
                <?= Html::a(
                    Yii::t(yii2admin, "Забыл пароль ?"),
                    ['/site/request-password-reset'],
                    [
                        'class' => 'ml-auto'
                    ]
                );?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(
                        \Yii::t(yii2admin, "Войти") . '<i class="icon-circle-right2 ml-2"></i>',
                        [
                                'class' => 'btn btn-primary btn-block',
                            'name' => 'login-button'
                        ]
                    )
                ?>
            </div>
            <div class="form-group text-center text-muted content-divider">
                <span class="px-2">
                    Don't have an account?
                </span>
            </div>
            <div class="form-group">
                <?= Html::a(
                        Yii::t(yii2admin, "Регистрация"),
                        [
                                '/site/registration'
                        ],
                        [
                            'class' => 'btn btn-light btn-block'
                        ]
                );?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>

