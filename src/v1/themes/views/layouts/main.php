<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\Breadcrumbs;
    use kamaelkz\yii2admin\v1\widgets\notifications\alert\FlashAlert;
    use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
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
    <body class="" data-current-domain-id="<?= Yii::$app->domainService->getCurrentDomainId();?>" data-change-lock-check-url="<?= Url::to(['/changelock/change-lock/check']);?>" data-change-lock-update-url="<?= Url::to(['/changelock/change-lock/update-lock']);?>">
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
                            <a href="#" class="header-elements-toggle text-default d-md-none">
                                <i class="icon-more"></i>
                            </a>
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
    <?= $this->render('include/magic-modal');?>
    <!-- magic-modal end-->
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
