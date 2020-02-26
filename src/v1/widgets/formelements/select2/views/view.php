<?php

$placeholder = isset($options['placeholder']) ? "data-placeholder='{$options['placeholder']}'" : null;
$multiple = $multiple ? 'multiple="multiple"' : null;

?>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-flat">
<!--            <div class="panel-heading">-->
<!--                <h5 class="panel-title">Single select</h5>-->
<!--                <div class="heading-elements">-->
<!--                    <ul class="icons-list">-->
<!--                        <li><a data-action="collapse"></a></li>-->
<!--                        <li><a data-action="reload"></a></li>-->
<!--                        <li><a data-action="close"></a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->

            <div class="panel-body">
                <div class="form-group">
                    <label>Basic select</label>
                    <select class="select" <?= $placeholder; ?> <?= $multiple; ?>>
                        <?php if ($placeholder): ?>
                            <option></option>
                        <?php endif ?>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $key => $value): ?>
                                <?php if (is_array($value)): ?>
                                    <optgroup label="<?= $key; ?>">
                                    <?php foreach ($value as $k => $v): ?>
                                        <option value="<?= $k ?>"><?= $v; ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="<?= $key ?>"><?= $value; ?></option>
                                <?php endif ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>