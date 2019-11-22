<?php 
    use common\helpers\LanguageHelper;
    use yii\helpers\ArrayHelper;
?>
<?php if(count($languages) == 1) :?>
    <?=
        Yii::$app->controller->renderPartial(
                $formViewPath ,
                ArrayHelper::merge(
                    [
                        'model' => $model ,
                        'form' => $form ,
                        'lang' => $defaultLanguage
                    ],
                    $viewParams
                )
        );
    ?>
<?php else :?>
    <div class="tabbable">
            <ul class="nav nav-tabs bg-primary nav-tabs-component nav-justified nav-tabs-solid">
                <?php foreach ($languages as $key => $lang):?>
                    <li class="<?= ($key == 0 ? 'active' : null);?>">
                        <a href="#language-tab-<?= $widget_id;?>-<?= $lang;?>" data-toggle="tab">
                            <?= LanguageHelper::availableLanguageLabel($lang);?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="tab-content">
                <?php foreach ($languages as $key => $lang):?>
                    <div class="tab-pane <?= ($key == 0 ? 'active' : null);?>" id="language-tab-<?= $widget_id;?>-<?= $lang;?>">
                        <?=
                            Yii::$app->controller->renderPartial(
                                    $formViewPath ,
                                    ArrayHelper::merge(
                                        [
                                            'model' => $model ,
                                            'form' => $form ,
                                            'lang' => $lang
                                        ],
                                        $viewParams
                                    )
                            );
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
    </div>
<?php endif;?>