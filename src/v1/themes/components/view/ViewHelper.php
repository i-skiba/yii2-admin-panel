<?php

namespace kamaelkz\yii2admin\v1\themes\components\view;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Вспомогательный класс для работы с придствалениями
 *
 * @todo need refactoring
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ViewHelper
{  
    /**
     * Дополнительные элементы в заголовке страницы
     * 
     * @var string 
     */
    private $_page_header_elements;
    
    /**
     * Дополнительные элементы в хлебных крошках страницы
     * 
     * @var string 
     */
    private $_breadcrumbs_elements;

    /**
     * Формирует элемент для добавления в верхнее меню элементов
     *
     * @param array $route
     * @param string $label
     * @param string $icon
     * @param array $options
     */
    public function pushPageHeader($route = ['create'], $label = null, $icon = null, $options = [])
    {
        if(! $icon) {
            $icon = 'icon-plus-circle2';
        }

        if(! $label) {
            $label = Yii::t('yii2admin', 'Новая запись');
        }

        $url = Url::to($route);
        $content = "<i class='{$icon} text-primary'></i><span>{$label}</span>";
        $defaultClass = 'btn btn-link btn-float text-default';
        if(! isset($options['class'])) {
            $options['class'] = $defaultClass;
        } else {
            $options['class'] .= " {$defaultClass}";
        }

        if(isset($options['data-url'])) {
            $url = '#';
        }

        $html = Html::a($content, $url, $options);
        $this->pushPageHeaderElement($html);
    }

    /**
     * Форимрует кнопку отправки формы в верхнем меню
     *
     * @todo рефактор
     *
     * @param string|null $label
     * @param string|null $icon
     * @param array $options
     */
    public function pushPageHeaderSubmit($label = null, $icon = null, $options = [])
    {
        if(! $icon) {
            $icon = 'icon-plus3';
        }

        if(! $label) {
            $label = Yii::t('yii2admin', 'Сохранить');
        }

        $content = "<i class='{$icon} text-primary'></i><span>{$label}</span>";
        $defaultClass = 'btn btn-link btn-float text-default';
        if(! isset($options['class'])) {
            $options['class'] = $defaultClass;
        } else {
            $options['class'] .= " {$defaultClass}";
        }

        if(isset($options['data-url'])) {
            $url = null;
        }

        $html = Html::submitButton($content, $options);
        $this->pushPageHeaderElement($html);
    }
    
    public function outputPageHeaderElements()
    {
        return $this->_page_header_elements;
    }
    
    public function pushPageHeaderElement($value)
    {
        $arguments = func_get_args();
        foreach ($arguments as $arg) {
            $this->_page_header_elements .= $arg;
        }
    }
    
    public function outputBreadcrumbsElements()
    {
        return $this->_breadcrumbs_elements;
    }
    
    public function pushBreadcrumbsElement($value)
    {
        $arguments = func_get_args();
        foreach ($arguments as $arg) {
            $this->_breadcrumbs_elements .= $arg;
        }
    }
}
