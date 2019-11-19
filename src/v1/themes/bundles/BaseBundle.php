<?php

namespace kamaelkz\yii2admin\v1\themes\bundles;

use yii\web\View;
use yii\web\AssetBundle;

/**
 * Базовый бандл темы
 *
 * @todo решить вопрос с $sourcePath придумать механизм
 *
 * @author kamael <kamaelkz@yandex.kz>
 */
abstract class BaseBundle extends AssetBundle
{
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}

