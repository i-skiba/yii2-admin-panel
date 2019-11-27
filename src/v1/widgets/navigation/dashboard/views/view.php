<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card text-center">
        <div class="card-body">
            <i class="<?= $icon;?> icon-2x text-<?= $color?> border-<?= $color?> border-3 rounded-round p-3 mb-3"></i>
            <h6 class="card-title">
                <?= $label;?>
            </h6>
            <?php if(! isset($description)) :?>
                <div class="text-size-small text-muted">
                    <?= $label;?>
                </div>
            <?php endif;?>
        </div>
        <div class="card-footer bg-white d-flex justify-content-center align-items-center p-0">
            <ul class="nav nav-tabs nav-tabs-bottom mb-0 border-0">
                <li class="nav-item">
                    <a href="<?= $url;?>" class="nav-link">
                        <?= Yii::t('yii2admin', 'Перейти');?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-cog5 mr-1"></i>
                        <?= Yii::t('yii2admin', 'Разделы');?>
                    </a>
                    <?php if($sections) :?>
                        <div class="dropdown-menu dropdown-menu-right">
                            <?= $sections;?>
                        </div>
                    <?php endif;?>
                </li>
            </ul>
        </div>
    </div>
</div>
