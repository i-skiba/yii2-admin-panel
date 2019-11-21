<?php
    use yii\helpers\Url;
?>

<li class="nav-item nav-item-submenu">
    <a href="#" class="nav-link">
        <i class="icon-stack"></i> <span>UIkit</span>
    </a>
    <ul class="nav nav-group-sub" data-submenu-title="Starter kit" style="display: none;">
        <li class="nav-item">
            <a href="<?= Url::to(['/uikit/widgets/index']);?>" class="nav-link">
                <?= Yii::t('yii2admin', 'Виджеты');?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= Url::to(['/uikit/crud/index']);?>" class="nav-link">
                <?= Yii::t('yii2admin', 'CRUD');?>
            </a>
        </li>
    </ul>
</li>