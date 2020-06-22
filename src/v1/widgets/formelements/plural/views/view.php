<?php

$pattern = '/[ ](\S\w*){(.*?)}/';
$matches = [];
$originMatches = [];
if (isset($model->{$targetAttr}) && !empty($model->{$targetAttr})) {
    preg_match_all($pattern, $model->{$targetAttr}, $matches);
}

preg_match_all($pattern, $origin, $originMatches);

$types = $originMatches[1];
$values = isset($matches[2]) ? $matches[2] : [];

?>
<?php if (isset($types) && !empty($types)): ?>
    <?php foreach ($types as $key => $type): ?>
        <?php // TODO доставать исключения
            if ($type == 'other') continue; ?>
        <?php
            $type = trim($type);
            $value = isset($values[$key]) && !empty($values[$key]) ? $values[$key] : $originMatches[2][$key];
        ?>
        <?= $form->field($model, "{$pluralAttr}[{$targetAttr}][{$type}]")
            ->textInput(['value' => $value, 'placeholder' => $type])->label("<b>{$type}</b>"); ?>
    <?php endforeach; ?>
<?php endif; ?>
