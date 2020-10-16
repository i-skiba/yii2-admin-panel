<?php

namespace kamaelkz\yii2admin\v1;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\web\Application;
use yii\web\Controller;
use yii\helpers\Url;
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
use kamaelkz\yii2admin\v1\components\UrlManager;

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
        # построение меню
        Event::on(Application::class, Application::EVENT_BEFORE_REQUEST, function($event) {
            # язык интерфейса
            if (!Yii::$app->getUser()->getIsGuest()) {
                $user = Yii::$app->getUser()->getIdentity();
                if (!empty($user->interface_iso)) {
                    Yii::$app->language = $user->interface_iso;
                }
            }
            # меню модул
            $event->sender->params = ArrayHelper::merge(
                Yii::$app->params,
                require __DIR__ . "/config/web/menu-sidebar.php"
            );

            # пытаемся искать меню в подпроекте backend
            $filePath = Yii::getAlias('@backend/config') . '/menu-sidebar.php';
            if (file_exists($filePath)) {
                $event->sender->params = ArrayHelper::merge(
                    Yii::$app->params,
                    require $filePath
                );
            }
        });
        # редирект на адрес с параметром текущего домена, если его нет в запросе
        Event::on(Controller::class, Controller::EVENT_BEFORE_ACTION, function() {
            $domain_id = Yii::$app->getRequest()->get('domain_id');
            if(! $domain_id) {
                Yii::$app->getResponse()->redirect(Url::current(['domain_id' => Yii::$app->domainService->getCurrentDomainId()], 302));
            }
            // set timezone
            $domain_data = Yii::$app->domainService->getDomainDataById($domain_id);
            if(isset($domain_data['timezone'])) {
                date_default_timezone_set($domain_data['timezone']);
            }
        });
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
            'yii\validators\StringValidator' => StringValidator::class,
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
     * @param string $fileName
     * @throws InvalidConfigException
     * @return array
     */
    public static function getConfiguration($type = self::WEB, $fileName = 'main')
    {
        if(! in_array($type, [self::WEB, self::CONSOLE])) {
            throw new InvalidConfigException('Configuration type is not defined.');
        }

        return ArrayHelper::merge(
            require __DIR__ . "/config/{$type}/{$fileName}.php",
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