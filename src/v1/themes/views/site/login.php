<?php

use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;
use kamaelkz\yii2admin\v1\themes\bundles\ImagesBundle;

$this->title = \Yii::t('backend', "Авторизация");
$imagePath = $this->assetBundles[ImagesBundle::class]->baseUrl;

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
                <img style="width:120px;" class="p-3 mb-2 mt-1" src="<?= $imagePath;?>/yii_logo.png" alt="">
                <h5 class="mb-0">
                    <?= \Yii::t('xray', "Авторизация");?>
                </h5>
                <span class="d-block text-muted">
                        <?= Yii::t('xray','Введите свои учетные данные ниже');?>
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
                    Yii::t('yii2admin', "Забыл пароль ?"),
                    ['/site/request-password-reset'],
                    [
                        'class' => 'ml-auto'
                    ]
                );?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(
                        \Yii::t('yii2admin', "Войти") . '<i class="icon-circle-right2 ml-2"></i>',
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
                        Yii::t('yii2admin', "Регистрация"),
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

