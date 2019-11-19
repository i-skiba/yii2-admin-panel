<?php

namespace kamaelkz\yii2admin\v1;

use Yii;
use yii\base\InvalidCallException;
use yii\base\Theme;
use yii\base\BootstrapInterface;
use yii\base\Widget;
use yii\web\AssetManager;
use kamaelkz\yii2admin\v1\ {
    widgets\Breadcrumbs,
    widgets\DetailView,
    widgets\lists\grid\ActionColumn,
    widgets\lists\grid\GridView,
    widgets\lists\ListView
};

/**
 * Первичная настройка компонента
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        Yii::$container->setDefinitions($this->getDefinations());
        Yii::configure(Yii::$app, $this->getConfigurations());
    }

    /**
     * Подмена классов
     *
     * @return array
     */
    private function getDefinations()
    {
        return [
            'yii\widgets\Breadcrumbs' => Breadcrumbs::class,
            'yii\widgets\ListView' => ListView::class,
            'yii\widgets\DetailView' => DetailView::class,
            'yii\grid\GridView' => GridView::class,
            'yii\grid\ActionColumn' => ActionColumn::class,
        ];
    }

    /**
     * Конфигурация компонента админки
     *
     * @return array
     */
    private function getConfigurations()
    {
        return [
            'aliases' => [
                '@yii2admin' => '@vendor/kamaelkz/yii2-admin-panel/v1',
            ],
            'modules' => [
                'uikit' => [
                    'class' => 'kamaelkz\yii2admin\v1\modules\uikit\Module'
                ],
            ],
            'components' => [
                'view' => [
                    'class' => 'kamaelkz\yii2admin\v1\themes\components\view\View',
                    'theme' => [
                        'class'=> Theme::class,
                        'basePath'=>'@yii2admin/themes'
                    ],
                ],
                'assetManager' => [
                    'class' => AssetManager::class,
                    'linkAssets' => true,
                    'appendTimestamp' => true,
                    'bundles' => [
                        'yii\bootstrap\BootstrapPluginAsset' => [
                            'js'=>[]
                        ],
                        'yii\bootstrap\BootstrapAsset' => [
                            'css' => [],
                        ],
                        'yii\web\JqueryAsset' => [
                            'sourcePath' => '@yii2admin/themes/resources',
                            'js' => [
                                'limitless/global_assets/js/main/jquery.min.js'
                            ],
                        ],
                    ],
                ],
            ],
            'controllerMap' => [
                'site' => [
                    'class' => 'kamaelkz\yii2admin\v1\controllers\DefaultController',
                ],
            ],
        ];
    }
}
//
//
///**
///* @todo решить проблемы с виджетами begin/end
// * @inheritDoc
// */
//public static function end()
//{
//    if (!empty(self::$stack)) {
//        $widget = array_pop(self::$stack);
//        $definations = Yii::$container->getDefinitions();
//        $calledClass = get_called_class();
//        $widgetClass = get_class($widget);
//        $value = $definations[$calledClass] ?? null;
//        if($value && $value['class'] === $widgetClass) {
//            $class = $value['class'];
//        } else {
//            $class = $calledClass;
//        }
//
//        if ($widgetClass === $class) {
//            /* @var $widget Widget */
//            if ($widget->beforeRun()) {
//                $result = $widget->run();
//                $result = $widget->afterRun($result);
//                echo $result;
//            }
//
//            return $widget;
//        }
//
//        throw new InvalidCallException('Expecting end() of ' . get_class($widget) . ', found ' . get_called_class());
//    }
//
//    throw new InvalidCallException('Unexpected ' . get_called_class() . '::end() call. A matching begin() is not found.');
//}