<?php

namespace kamaelkz\yii2admin\v1\widgets\navigation;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Inflector;
use concepture\yii2logic\widgets\Widget as CoreWidget;

/**
 * Базовый класс виджета
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class NavigationWidget extends CoreWidget
{
    /**
     * @var array массив элементов
     */
    public $items = [];

    /**
     * Группа элементов
     *
     * @param array $item
     *
     * @return string|null
     */
    protected abstract function getGroup($item);

    /**
     * Элемент
     *
     * @param array $item
     *
     * @return string|null
     */
    protected abstract function getElement($item);

    /**
     * @inheritDoc
     */
    public function run()
    {
        parent::run();
        if(! $this->items) {
            if(! isset(Yii::$app->params['yii2admin-navigation'])) {
                throw new InvalidConfigException('parameter sidebar must be set.');
            }

            $this->items = Yii::$app->params['yii2admin-navigation'];
        }

        return $this->getContent();
    }
    /**
     * Возвращает контент виджета
     *
     * @return string|null
     */
    protected function getContent()
    {
        $content = null;
        if(! $this->items) {
            return $content;
        }
        # сортировка элементов
        usort($this->items, function($a, $b) {
            $a = ( $a['position'] ?? 999 );
            $b = ( $b['position'] ?? 999 );

            if($a == $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        });
        foreach ($this->items as $item) {
            if(! isset($item['children'])) {
                $content .= $this->getElement($item);
            } else {
                $content .= $this->getGroup($item);
            }
        }

        echo $content;
    }

    /**
     * Признак отображения элемента
     *
     * @param array $item
     * @return bool|mixed
     */
    protected function isVisible($item)
    {
        $short = (new \ReflectionClass($this))->getShortName();
        $type =  strtolower($short);
        $visible = true;
        if(isset($item['visible'][$type])) {
            if($item['visible'][$type] instanceof \Closure) {
                $visible = call_user_func($item['visible'][$type]);
            } else {
                $visible = (bool) $item['visible'][$type];
            }
        }

        return $visible;
    }

    /**
     * Получение метки элемента
     *
     * @param array $item
     *
     * @return string|null
     */
    protected function getLabel($item)
    {
        $result = $item['label'] ?? null;
        if(isset($item['icon'])) {
            $label = Html::tag('span', $result);
            $icon = Html::tag('i', null, ['class' => $item['icon']]);
            $result = "{$icon} {$label}";
        }

        return $result;
    }
}