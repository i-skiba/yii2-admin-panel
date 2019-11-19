<?php 
    use common\helpers\Url;
    use kamaelkz\yii2admin\v1\themes\bundles\ImagesBundle;

    $imageBundlePath = $this->assetBundles[ImagesBundle::class]->baseUrl;
?>
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
        <div class="sidebar-content">
            <div class="sidebar-user">
                <div class="card-body">
                    <div class="media">
                        <div class="mr-3">
                            <a href="#"><img src="<?php echo $imageBundlePath;?>/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="38" height="38"></a>
                        </div>

                        <div class="media-body">
                            <div class="media-title font-weight-semibold">
                                <?//= Yii::$app->user->identity->lastname;?><!-- --><?php //echo Yii::$app->user->identity->firstname;?>
                            </div>
                            <div class="font-size-xs opacity-50">
                                <i class="icon-pin font-size-sm"></i> &nbsp;Santa Ana, CA
                            </div>
                        </div>

                        <div class="ml-3 align-self-center">
                            <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <li class="nav-item">
                        <a href="<?= Url::to(['/site/index']);?>" class="nav-link active">
                            <i class="icon-home4"></i>
                            <span>
                                <?= Yii::t('yii2admin', 'Главная');?>
                            </span>
                        </a>
                    </li>
                    <?= $this->render('elements');?>
                    <?= $this->render('uikit');?>
                </ul>
            </div>
        </div>
</div>
