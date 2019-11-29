<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card text-center">
<!--        <div class="card-body">-->
<!--            <i class="--><?//= $icon;?><!-- icon-2x text---><?//= $color?><!-- border---><?//= $color?><!-- border-3 rounded-round p-3 mb-3"></i>-->
<!--            <h6 class="card-title">-->
<!--                --><?//= $label;?>
<!--            </h6>-->
<!--            --><?php //if(! isset($description)) :?>
<!--                <div class="text-size-small text-muted">-->
<!--                    --><?//= $label;?>
<!--                </div>-->
<!--            --><?php //endif;?>
<!--        </div>-->
        <div class="card-body">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="<?= $icon;?> icon-3x text-<?= $color?>"></i>
                </div>

                <div class="media-body text-right">
                    <h6 class="font-weight-semibold mb-0">
                        <?= $label;?>
                    </h6>
                    <span class="text-muted">
                        <?= $label;?>
                    </span>
                </div>
            </div>
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
