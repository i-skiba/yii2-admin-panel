<?php

namespace kamaelkz\yii2admin\v1\widgets\navigation\dashboard;

use yii\helpers\Url;
use kamaelkz\yii2admin\v1\widgets\navigation\NavigationWidget;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Dashboard extends NavigationWidget
{
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

        $sections = null;
        foreach ($item['children'] as $child) {
            $sections .= $this->getElement($child);
        }

        return $this->render('view', [
            'label' => $item['label'] ?? null,
            'url' => ($item['url'] ? Url::to($item['url']) : null),
            'icon' => $item['icon'] ?? null,
            'color' => $item['color'] ?? 'primary',
            'description' => $item['description'] ?? null,
            'sections' => $sections,
        ]);
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

        return $this->render('element', [
            'label' => $this->getLabel($item),
            'url' => ($item['url'] ? Url::to($item['url']) : null)
        ]);
    }
}