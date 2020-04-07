<?php

namespace kamaelkz\yii2admin\v1\modules\hints\widgets;

use Yii;
use kamaelkz\yii2admin\v1\themes\components\view\View;
use concepture\yii2logic\bundles\Bundle as BaseBundle;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Bundle extends BaseBundle
{
    public $css = [
        'styles/yii2-hints.css',
    ];

    public $js = [
        'scripts/yii2-hints.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    /**
     * @param string $json
     */
    public static function registerJs($json)
    {
        $script = <<<JS
        $(document).ready(function() {
            yii2admin.initAdminHints({$json});
        })
JS;

        Yii::$app->getView()->registerJs($script, View::POS_END);
    }
}