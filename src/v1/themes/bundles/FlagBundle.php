<?php

namespace kamaelkz\yii2admin\v1\themes\bundles;

use concepture\yii2logic\bundles\Bundle;

/**
 * Бандл для флагов
 * Class FlagBundle
 * @package kamaelkz\yii2admin\v1\themes\bundles
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class FlagBundle extends Bundle
{
    public $sourcePath = '@yii2admin/themes/resources';

    public $css = [
        'styles/yii2admin/flag.css',
    ];
}
