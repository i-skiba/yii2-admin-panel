<style>
    .nav-tabs.nav-justified > li > a {
        border : none;
    }
</style>
<div class="tabbable" style=''>
    <ul class="nav nav-tabs nav-justified nav-tabs-highlight no-margin">
        <?php foreach ($items as $item) :?>
            <li class="<?= $item->getIsActive() ?>">
                <a href="<?= $item->getRoute()?>">
                    <?= $item->getLabel();?>
                </a>
            </li>
        <?php endforeach;?>
    </ul>
</div>
