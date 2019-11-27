<?php

namespace kamaelkz\yii2admin\v1\widgets\navigation\sidebar;

use yii\helpers\Url;
use kamaelkz\yii2admin\v1\themes\components\view\SidebarHelper;
use yii\base\InvalidConfigException;
use kamaelkz\yii2admin\v1\widgets\navigation\NavigationWidget;

/**
 * Виджет Sidebar
 *
 * @todo : stdClass $item или Model
 * @todo : на развитие можно использовать какой-то конфиг у модулей для формирования меню
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Sidebar extends NavigationWidget
{
    /**
     * @inheritDoc
     */
    protected function getGroup($item) : string
    {
        if(! $this->isVisible($item)) {
            return null;
        }

        $elements = null;
        foreach ($item['children'] as $child) {
            $elements .= $this->getElement($child);
        }

        return $this->render('view', [
            'url' => ( $item['url'] ? Url::to($item['url']) : '#' ),
            'tooltip' => ( $item['label'] ?? null ),
            'label' => $this->getLabel($item),
            'elements' => $elements,
            'active' => $this->getActive($item),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function getElement($item) : string
    {
        if(! $this->isVisible($item)) {
            return null;
        }

        return $this->render('element', [
            'url' => ( $item['url'] ? Url::to($item['url']) : '#' ),
            'label' => $this->getLabel($item),
            'active' => $this->getActive($item),
        ]);
    }

    /**
     * Возвращает класс активного элемента по правилам
     *
     * @param array $item
     * @return mixed|null
     * @throws InvalidConfigException
     */
    protected function getActive($item)
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