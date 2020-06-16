<?php
    use yii\widgets\Pjax;
?>
<div id="magic-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Magic modal</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?php Pjax::begin([
                        'id' => 'magic-modal-pjax',
                        'scrollTo' => 'false',
                        'enablePushState' => false
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>