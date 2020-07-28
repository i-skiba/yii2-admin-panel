<?php

use concepture\yii2handbook\enum\DeclinationFormatEnum;

$pattern = '/[ ](\S\w*){(.*?)}/';
$matches = [];
$originMatches = [];
if (isset($model->{$targetAttr}) && !empty($model->{$targetAttr})) {
    preg_match_all($pattern, $model->{$targetAttr}, $matches);
}

preg_match_all($pattern, $origin, $originMatches);

$types = $originMatches[1];
$values = isset($matches[2]) ? $matches[2] : [];
$allowedTypes = array_filter($types, function($type) use ($declination_format) {
    $result = null;
    switch ($declination_format) {
        case DeclinationFormatEnum::FULL;
            $result =  $type;
            break;
        case DeclinationFormatEnum::TWO;
            if(in_array($type, ['one', 'other'])) {
                $result =  $type;
            }

            break;
        case DeclinationFormatEnum::THREE;
            if(in_array($type, ['one', 'many', 'few'])) {
                $result =  $type;
            }

            break;
    }

    if($result) {
        return $result;
    }
});

?>
<?php if (isset($types) && !empty($types)): ?>
    <?php foreach ($types as $key => $type): ?>
        <?php
            $type = trim($type);
            $value = isset($values[$key]) && ! empty($values[$key]) ? $values[$key] : $originMatches[2][$key];
        ?>
        <?php
            $field = $form->field($model, "{$pluralAttr}[{$targetAttr}][{$type}]");
            if(in_array($type, $allowedTypes)) {
                $field->textInput(['value' => $value, 'placeholder' => $type])->label("<b>{$type}</b>");
            } else {
                $field->hiddenInput(['value' => $value])->label(false);
            }

            echo $field;
        ?>
    <?php endforeach; ?>
<?php endif; ?>
