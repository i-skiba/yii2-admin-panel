<?php

namespace kamaelkz\yii2admin\v1\controllers;

use concepture\yii2logic\controllers\web\Controller;
use concepture\yii2logic\helpers\UrlHelper;
use kamaelkz\yii2admin\v1\controllers\traits\ControllerTrait;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Базовы контроллер административной части приложения
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseController extends Controller
{
    use ControllerTrait;

    public function beforeAction($action)
    {
        $this->setUpdateUrlMetaTag($action->id);

        return parent::beforeAction($action);
    }

    /**
     * выставляем метатег с ссылкой на update сущности только с параметрами первичного ключа
     * используется для работы AdminChangeLock
     *
     * @param string $action_id
     */
    protected function setUpdateUrlMetaTag($action_id)
    {
        if ($action_id != 'update') {
            return;
        }

        $model = $this->getService()->getRelatedModel();
        $primaryKey = $model->primaryKey();
        $url = 'http://example.com' . Yii::$app->request->url;
        $parsed = parse_url($url);
        $queryArray = explode('&', $parsed['query']);
        $params = [];
        foreach ($queryArray as $value) {
            $tmp = explode('=', $value);
            if (! isset($tmp[0]) && ! isset($tmp[1])) {
                continue;
            }

            if (! in_array($tmp[0], $primaryKey)) {
                continue;
            }

            $params[] = $value;
        }

        $queryArray = implode('&', $params);
        $parsed['query'] = $queryArray;
        $url = UrlHelper::buildUrl($parsed);
        $url = str_replace('http://example.com', '', $url);
        Yii::$app->view->registerMetaTag([
            'name' => 'update_url',
            'content' => $url
        ]);
    }
}