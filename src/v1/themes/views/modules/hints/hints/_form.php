<?php

use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;

$saveRedirectButton = Html::saveRedirectButton();
$saveButton = Html::saveButton();

?>

<?php Pjax::begin(['formSelector' => '#hints-form']); ?>
<!--    --><?php //if (Yii::$app->localeService->catalogCount() > 1): ?>
<!--        <ul class="nav nav-tabs nav-tabs-solid nav-justified bg-light">-->
<!--            --><?php //foreach (Yii::$app->localeService->catalog() as $key => $locale):?>
<!--                <li class="nav-item">-->
<!--                    --><?//= Html::a(
//                        $locale,
//                        \yii\helpers\Url::current(['locale' => $key]),
//                        ['class' => 'nav-link ' . ($key ==  $model->locale   ? "active" : "")]
//                    ) ?>
<!--                </li>-->
<!--            --><?php //endforeach;?>
<!--        </ul>-->
<!--    --><?php //endif; ?>
    <?php
        $form = ActiveForm::begin(['id' => 'hints-form']);

        echo Html::activeHiddenInput($model, 'locale');
    ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?= $form->field($model, 'name')->textInput([
                            'maxlength' => true,
                            'style'=> 'text-transform: uppercase',
                            'disabled' => isset($originModel) ? true : false
                    ]) ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?= $form->field($model, 'caption')->textInput(['maxlength' => true]);?>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <?= $form->field($model, 'value')->textarea();?>
                </div>
            </div>
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
