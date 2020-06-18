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
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use kamaelkz\yii2cdnuploader\Yii2CdnUploader;
use concepture\yii2logic\validators\StringValidator;

/**
 * Первичная настройка компонента
 *
 * @todo: решить проблемы с виджетами begin/end
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Yii2Admin implements BootstrapInterface
{
    const WEB = 'web';
    const CONSOLE = 'console';

    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        $this->setClassmap();
        Yii::$container->setDefinitions($this->getDefinations());
    }

    /**
     * Подмена классов в контейнере
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
            'yii\validators\StringValidator' => StringValidator::class
        ];
    }

    /**
     * Подмена классов в карте
     */
    private function setClassmap()
    {
        Yii::$classMap['yii\helpers\Html'] = '@yii2admin/dependency_injection/classmap/Html.php';
    }

    /**
     * Конфигурация компонента админки
     *
     * @param string $type
     * @throws InvalidConfigException
     * @return array
     */
    public static function getConfiguration($type = self::WEB)
    {
        if(! in_array($type, [self::WEB, self::CONSOLE])) {
            throw new InvalidConfigException('Configuration type is not defined.');
        }

        return ArrayHelper::merge(
            require __DIR__ . "/config/{$type}/main.php",
            Yii2CdnUploader::getConfiguration()
        );
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