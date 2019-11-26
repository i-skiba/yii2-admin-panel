<?php

namespace kamaelkz\yii2admin\v1\widgets;

use Yii;
use yii\helpers\Url;
use kamaelkz\yii2admin\v1\themes\components\view\SidebarHelper;
use yii\base\InvalidConfigException;
use concepture\yii2logic\widgets\Widget;

/**
 * Виджет Sidebar
 *
 * @todo : вынести шабллоны, сделать кастомизацию шаблонов
 * @todo : stdClass $item или Model
 * @todo : на развитие можно использовать какой-то конфиг у модулей для формирования меню
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Sidebar extends Widget
{
    /**
     * @var array массив элементов
     */
    public $items = [];

    /**
     * @inheritDoc
     */
    public function run()
    {
        parent::run();
        $this->setItems();

        return $this->getContent();
    }

    /**
     * Установка элементов меню
     */
    protected function setItems()
    {
        if($this->items) {
            return;
        }

        if(! isset(Yii::$app->params['yii2admin-sidebar'])) {
            throw new InvalidConfigException('parameter sidebar must be set.');
        }

        $this->items = Yii::$app->params['yii2admin-sidebar'];
    }

    /**
     * Возвращает контент виджета
     *
     * @return string|null
     */
    protected function getContent()
    {
        $result = null;
        if(! $this->items) {
            return $result;
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
                $result .= $this->getElement($item);
            } else {
                $result .= $this->getGroup($item);
            }
        }

        echo $result;
    }

    /**
     * Группа элементов
     *
     * @param array $item
     *
     * @return string|null
     */
    protected function getGroup($item)
    {
        if(! $this->isVisible($item)) {
            return null;
        }

        $elements = null;
        foreach ($item['children'] as $child) {
            $elements .= $this->getElement($child);
        }

        $template =  <<<HTML
            <li class="nav-item nav-item-submenu %ACTIVE%">
                <a href="#" class="nav-link">
                    <i class="%ICON%"></i> <span>%LABEL%</span>
                </a>
                <ul class="nav nav-group-sub" data-submenu-title="%LABEL%">
                    %ELEMENTS%
                </ul>
            </li>
HTML;

        return str_replace(
            [
                '%LABEL%',
                '%ICON%',
                '%ELEMENTS%',
                '%ACTIVE%'
            ],
            [
                ($item['label'] ?? null),
                ($item['icon'] ?? null),
                $elements,
                $this->getActiveClass($item)
            ],
            $template
        );
    }

    /**
     * Элемент
     *
     * @param array $item
     *
     * @return string|null
     */
    protected function getElement($item)
    {
        if(! $this->isVisible($item)) {
            return null;
        }

        $template = <<<HTML
            <li class="nav-item">
                <a href="%URL%" class="nav-link %ACTIVE%">
                    <i class="%ICON%"></i> <span>%LABEL%</span>
                </a>
            </li>
HTML;

        return str_replace(
            [
                '%LABEL%',
                '%ICON%',
                '%URL%',
                '%ACTIVE%',
            ],
            [
                ($item['label'] ?? null),
                ($item['icon'] ?? null),
                $item['url'] ? Url::to($item['url']) : null,
                $this->getActiveClass($item)
            ],
            $template
        );

    }

    /**
     * Признак отображения элемента
     *
     * @param array $item
     * @return bool|mixed
     */
    protected function isVisible($item)
    {
        $visible = true;
        if(isset($item['visible'])) {
            if($item['visible'] instanceof \Closure) {
                $visible = call_user_func($item['visible']);
            } else {
                $visible = (bool) $item['visible'];
            }
        }

        return $visible;
    }

    /**
     * Возвращает класс активного элемента по правилам
     *
     * @param array $item
     * @return mixed|null
     * @throws InvalidConfigException
     */
    protected function getActiveClass($item)
    {
        if(! isset($item['active'])) {
            return null;
        }

        $setting = $item['active'];
        if(! isset($setting['type']) || ! isset($setting['rule'])) {
            throw new InvalidConfigException('Item active type and rule must be set.');
        }

        $params = is_array($setting['rule']) ? $setting['rule'] : [$setting['rule']];

        return call_user_func_array([SidebarHelper::class, $setting['type']], $params);
    }
}