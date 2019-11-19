<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use kamaelkz\yii2admin\v1\widgets\notifications\alert\FlashAlert;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
use kamaelkz\yii2admin\v1\themes\bundles\ {
    ImagesBundle,
    StylesBundle,
    ScriptsBundle
};
?>
<?
    ImagesBundle::register($this);
    StylesBundle::register($this);
    ScriptsBundle::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>
            <?= Html::encode($this->getTitle()) ?>
        </title>
        <?php $this->head() ?>
    </head>
    <body class="">
    <?php $this->beginBody() ?>
    <?= $this->render('include/navbar/main');?>
    <div class="page-content">
        <?= $this->render('include/sidebar/main');?>
        <div class="content-wrapper">
            <?php if($this->getTitle() || $this->getTitlePrefix()) :?>
                <div class="page-header page-header-light">
                    <div class="page-header-content header-elements-md-inline">
                        <div class="page-title d-flex">
                            <h4>
                                <?php if($this->getTitlePrefix()) :?>
                                    <span class="font-weight-semibold">
                                        <?= $this->getTitlePrefix();?>
                                    </span>
                                <?php endif;?>
                                <?php if($this->getTitle() && $this->getTitlePrefix()) :?>
                                -
                                <?php endif;?>
                                <?= $this->getTitle() ?>
                            </h4>
                        </div>
                        <div class="header-elements d-none">
                            <div class="d-flex justify-content-center">
                                <?= $this->viewHelper()->outputPageHeaderElements();?>
                            </div>
                        </div>
                    </div>
                    <?php if($this->getBreadcrumbs()):?>
                        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                            <div class="d-flex">
                                <?= Breadcrumbs::widget(); ?>
                            </div>
                            <div class="header-elements d-none">
                                <div class="breadcrumb justify-content-center">
                                    <?= $this->viewHelper()->outputBreadcrumbsElements();?>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            <?php endif;?>
            <div class="content">
                <div class="admin-flash">
                    <?php if(Yii::$app->session->hasFlash(FlashAlertEnum::SUCCESS)):?>
                        <?= FlashAlert::widget(); ?>
                    <?php endif;?>
                    <?php if(Yii::$app->session->hasFlash(FlashAlertEnum::ERROR)):?>
                        <?= FlashAlert::widget([
                            'type' => FlashAlertEnum::ERROR
                        ]);
                        ?>
                    <?php endif;?>
                </div>
                <?php echo $content ?>
            </div>
            <?= $this->render('include/footer');?>
        </div>
    </div>
    <div id="magic-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">
                        Basic modal
                    </h6>
                </div>
                <?php Pjax::begin([
                    'id' => 'magic-modal-pjax',
                    'scrollTo' => 'false',
                    'enablePushState' => false
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    <!-- magic-modal end-->
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
