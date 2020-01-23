<?php

    use kamaelkz\yii2admin\v1\forms\BaseForm;
    use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;

?>

<?php if(isset($searchViewPath)) :?>
    <div class='card search-box <?= ($collapsed ? 'card-collapsed' : null) ;?>'>
        <?php if($searchCollapsed):?>
            <div class="card-header header-elements-inline">
                <h6 class="card-title">
                    <?php if( $selectedFilterCount ):?>
                        <span class="badge bg-primary">
                            <?= Yii::t('yii2admin', 'Выбрано');?> : <b><?= $selectedFilterCount;?></b>
                        </span>
                    <?php else:?>
                        <i class="icon-filter3" data-popup="tooltip" data-placement="right" data-original-title="<?= Yii::t('yii2admin', 'Фильтрация');?>"></i>
                    <?php endif;?>
                </h6>
                <div class="heading-elements">
                    <div class="list-icons">
                        <a data-action="collapse" class="rotate-180"></a>
                    </div>
                </div>
            </div>
            <hr class='no-margin'>
        <?php endif;?>
        <div class="card-body">
            <?php
                $form = ActiveForm::begin([
                    'id' => $form_id ??  'search-form',
                    'method' => 'GET',
                    'action' => Url::canonical(),
                    'fieldConfig' => [
                        'template' => '{label} {input}'
                    ]
                ])
            ?>
                <?php if(isset($extendBeforeContent)) :?>
                    <?= $extendBeforeContent;?>
                <?php endif;?>
                <?= $this->renderFile($searchViewPath, ['form' => $form, 'model' => $model, 'searchParams' => $searchParams]);?>
                <?php if(isset($extendAfterContent)) :?>
                    <?= $extendAfterContent;?>
                <?php endif;?>
                <div class="text-right">
                    <?=  Html::button(
                        '<b><i class="icon-cross2"></i></b>' . Yii::t('yii2admin', 'Сбросить'),
                        [
                            'class' => 'btn bg-grey btn-labeled btn-labeled-left search-clear',
                        ]
                    );
                    ?>
                    <?=  Html::submitButton(
                        '<b><i class="icon-search4"></i></b>' . Yii::t('yii2admin', 'Применить'),
                        [
                            'class' => 'btn bg-success btn-labeled btn-labeled-left ml-1',
                        ]
                    );
                    ?>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
<?php endif;?>
<div class='card admin-grid-box table-responsive'>
    <div class='datatable-header length-left'>
        <div class='dataTables_info'>
            {summary}
        </div>
        <div class='dataTables_paginate'>
            {pager}
        </div>
    </div>
    {items}
    <div class='datatable-footer info-right'>
        <div class='dataTables_paginate'>
            {pager}
        </div>
    </div>
</div>