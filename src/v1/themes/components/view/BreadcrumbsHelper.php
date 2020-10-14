<?php

namespace kamaelkz\yii2admin\v1\themes\components\view;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use concepture\yii2logic\helpers\ClassHelper;

/**
 * Вспомогательный класс для работы с хлебными крошками
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class BreadcrumbsHelper
{
    /**
     * Формирование хлебных крошек для таблиц с деревьями
     *
     * @param Model $model
     * @param null|string $captionAttribute
     * @param null|string $identityAttribute
     * @param null|string $viewTitle
     *
     * @param callback|null $captionCallback
     * @return array
     */
    public static function getClosurePath($model, $captionAttribute = null, $identityAttribute = "id", $viewTitle = null, $captionCallback = null)
    {
        $breadcrumb[] = [
            'label' => $model::label(),
            'url' => ['index']
        ];
        $serviceName = ClassHelper::getServiceName($model , ["Search", "Form"]);
        $i = 0;
        $parents = Yii::$app->{$serviceName}->getParentsByTree($model->{$identityAttribute}, true);
        if(empty($parents)) {
            unset($breadcrumb[0]['url']);

            return $breadcrumb;
        }

        $count = count($parents);
        foreach ($parents as $parent) {
            $captionValue = $parent->{$captionAttribute};
            if (is_callable($captionCallback)){
                $captionValue = call_user_func($captionCallback, $captionValue);
            }

            $i++;
            if($i != $count || $viewTitle !== null) {
                $breadcrumb[] = [
                    'label' => $captionValue,
                    'url' => ['index' , 'parent_id' => $parent->id]
                ];

                continue;
            }

            $breadcrumb[] = $captionValue;
        }

        if($viewTitle !== null){
            $breadcrumb[] = $viewTitle;
        }

        return $breadcrumb;
    }
}