<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="/" target="_blank" class="d-inline-block">
            <?= $this->render('logo');?>
        </a>
    </div>
    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
        <?php if(Yii::$app->getView()->viewHelper()->getSecondSidebarState()) :?>
            <button class="navbar-toggler sidebar-mobile-secondary-toggle" type="button">
                <i class="icon-more"></i>
            </button>
        <?php endif;?>
    </div>
    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
            <?= $this->render('nav_left');?>
        </ul>
        <span class="ml-md-3 mr-md-auto"></span>
        <ul class="navbar-nav">
            <?= $this->render('nav_right');?>
            <?= $this->render('nav_user');?>
        </ul>
    </div>
</div>