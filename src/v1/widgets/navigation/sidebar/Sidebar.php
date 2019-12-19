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
    protected function getGroup($item)
    {
        if(! $this->isVisible($item)) {
            return null;
        }

        $elements = null;
        foreach ($item['children'] as $child) {
            $elements .= $this->getElement($child);
        }

        return $this->render('view', [
            'url' => $this->getUrl($item),
            'tooltip' => ( $item['label'] ?? null ),
            'label' => $this->getLabel($item),
            'elements' => $elements,
            'active' => $this->getActive($item),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function getElement($item)
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
        if(! isset($setting['rules'])) {
            throw new InvalidConfigException('Item active rules must be set.');
        }

        $params = is_array($setting['rules']) ? $setting['rules'] : [$setting['rules']];
        $result = null;
        foreach ($params as $type => $args) {
            $class = SidebarHelper::ACTIVE_CLASS;
            if(isset($item['children'])) {
                $class = SidebarHelper::ACTIVE_GROUP_CLASS;
            }

            $args[] = $class;
            $active = call_user_func_array([SidebarHelper::class, $type], $args);
            if(! $active) {
                continue;
            }

            $result = $active;
        }

        return $result;
    }
}