<?php
    use common\helpers\Url;
    use kamaelkz\yii2admin\v1\themes\bundles\ImagesBundle;
    
    $imageBundlePath = $this->assetBundles[ImagesBundle::class]->baseUrl;
?>

<li class="nav-item dropdown dropdown-user">
    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
        <img src="<?php echo $imageBundlePath;?>/placeholders/placeholder.jpg" class="rounded-circle mr-2" alt="" height="34">
<!--        <span>--><?//Yii::$app->user->identity->firstname;?><!--</span>-->
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="<?= Url::to(['/site/logout']);?>" class="dropdown-item">
            <i class="icon-switch2"></i> <?= Yii::t(yii2admin,'Выход');?>
        </a>
    </div>
</li>