<?php
    use yii\helpers\Html;
    use kamaelkz\yii2admin\v1\themes\bundles\ {
        StylesBundle,
        ScriptsBundle
    };
    
    StylesBundle::register($this);
    ScriptsBundle::register($this);
?>
<?= $this->render('include/resources');?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?php echo Yii::$app->language ?>">
        <head>
            <meta charset="<?php echo Yii::$app->charset ?>">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?php echo Html::csrfMetaTags() ?>
            <title>
                <?php echo Html::encode($this->getTitle()) ?>
            </title>
            <?php $this->head() ?>
        </head>
        <body class="">
            <?php $this->beginBody() ?>
                <div class="page-content">
                    <div class="content-wrapper">
                        <div class="content d-flex justify-content-center align-items-center">
                            <?php echo $content ?>
                        </div>
                        <?= $this->render('/layouts/include/footer');?>
                    </div>
                </div>
            <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>
