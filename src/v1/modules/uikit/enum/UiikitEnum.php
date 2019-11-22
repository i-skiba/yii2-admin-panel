<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\enum;

use concepture\yii2logic\enum\Enum;

/**
 * Перечисления модуля
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class UiikitEnum extends Enum
{
    const SCENARIO_DEPEND_SELECTS = 'scenario_depend_selects';
    const DEPEND_CHANGE_VALUE = 2;

    /**
     * @return array
     */
    public static function getDropdownList()
    {
        return [
            1 => 'Элемент 1',
            2 => 'Элемент 2',
            3 => 'Элемент 3',
            4 => 'Элемент 4',
        ];
    }

    /**
     * @return array
     */
    public static function getCheckboxList()
    {
        return [
            1 => 'Элемент 1',
            2 => 'Элемент 2',
            3 => 'Элемент 3',
            4 => 'Элемент 4',
            5 => 'Элемент 5',
            6 => 'Элемент 6',
            7 => 'Элемент 7',
        ];
    }
}