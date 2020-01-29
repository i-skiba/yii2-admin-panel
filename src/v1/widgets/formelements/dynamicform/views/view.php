<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 text-left">
        <table class="table table-bordered table-striped dynamic-form-items">
            <thead>
            <tr>
                <td></td>
                <?php foreach ($attributes as $attribute => $settings) :?>
                    <td class="text-center">
                        <?= $model->getAttributeLabel($attribute);?>
                    </td>
                <?php endforeach; ?>
            <tr>
            </thead>
            <tbody>
            <?php foreach ($collections as $key => $collection) :?>
                <tr class="dynamic-form-item">
                    <td class="text-center" style="min-width: 5%;">
                        <button type="button" class="btn btn-primary btn-icon dynamic-form-remove-item">
                            <i class="icon-minus-circle2 "></i>
                        </button>
                    </td>
                    <?php foreach ($attributes as $attribute => $settings) :?>
                        <td class="text-center">
                            <?= $form->field($collection, "[$key]{$attribute}")->textInput()->label(false);?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 text-left">
        <button type="button" class="btn btn-primary btn-labeled btn-labeled-left mt-3 dynamic-form-add-item">
            <b>
                <i class="icon-plus-circle2 "></i>
            </b>
            <?= Yii::t('yii2admin', 'Добавить');?>
        </button>
    </div>
</div>