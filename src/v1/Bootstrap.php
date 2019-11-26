<?php

namespace kamaelkz\yii2admin\v1;

use Yii;
use yii\base\BootstrapInterface;
use kamaelkz\yii2admin\v1\ {
    widgets\Breadcrumbs,
    widgets\DetailView,
    widgets\lists\grid\ActionColumn,
    widgets\lists\grid\GridView,
    widgets\lists\ListView
};
use yii\helpers\ArrayHelper;

/**
 * Первичная настройка компонента
 *
 * @todo: абстрагировать bootstrap
 * @todo: решить проблемы с виджетами begin/end
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
        $config = $this->getConfigurations();
        if(! $config || ! is_array($config)) {
            return;
        }

        foreach ($config as $key => $value) {
            switch ($key) {
                case 'aliases' :
                    foreach ($config['aliases'] as $alias => $path) {
                        Yii::setAlias($alias, $path);
                    }

                    break;
            }

            if(! property_exists(Yii::$app, $key)) {
                continue;
            }

            $item = &$config[$key];
            $item = ArrayHelper::merge(Yii::$app->{$key}, $item);
        }

        Yii::configure(Yii::$app, $config);
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
        return require __DIR__ . '/config/main.php';
    }
}
//
//
///**
///*
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