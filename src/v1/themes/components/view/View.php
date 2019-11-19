<?php

namespace kamaelkz\yii2admin\v1\themes\components\view;

use yii\web\View as Base;

/**
 * Представление шаблона
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class View extends Base
{
    /**
     * @var array
     */
    public $params = [
        'breadcrumbs' => []
    ];

    /**
     * @var string приставка к заголовку
     */
    private $titlePrefix = '';

    /**
     * Класс хэлпер
     * 
     * @var string
     */
    public $helperClass = '\kamaelkz\yii2admin\v1\themes\components\view\ViewHelper';
    
    /**
     * Экземпляр класса хэлпера
     * 
     * @var ViewHelper
     */
    private $viewHelper;
    
    /**
     * Доступ к хэлперу
     * 
     * @return ViewHelper
     */
    public function viewHelper()
    {
        if(! $this->viewHelper) {
            $this->viewHelper = new $this->helperClass($this);
        }

        return $this->viewHelper;
    }

    /**
     * Возвращает хлебные крошки
     *
     * @return array|null
     */
    public function getBreadcrumbs()
    {
        return $this->params['breadcrumbs'] ?? null;
    }

    /**
     * Добавление элемента в хлебные крошки
     *
     * @param mixed $value
     */
    public function pushBreadcrumbs($value)
    {
        $this->params['breadcrumbs'][] = $value;
    }

    /**
     * Установка заголовка страницы
     *
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Возвращает заголовок страницы
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Установка приставки к заголовку страницы
     *
     * @param string $title
     */
    public function setTitlePrefix(string $titlePrefix)
    {
        $this->titlePrefix = $titlePrefix;
    }

    /**
     * Возвращает приставку заголовока страницы
     *
     * @return string
     */
    public function getTitlePrefix() : string
    {
        return $this->titlePrefix;
    }

    /**
     * Поиск сначало проектного представления, после компонента админки
     *
     * @inheritDoc
     */
    public function render($view, $params = [], $context = null)
    {
        $appViewFile = $this->findViewFile($view, $context);
        if (is_file($appViewFile) && file_exists($appViewFile)) {
            $themeBasePath = $this->theme->basePath;
            $this->theme->setBasePath('@app');
            $result = $this->renderFile($appViewFile, $params, $context);
            $this->theme->setBasePath($themeBasePath);

            return $result;
        }

        return parent::render($view, $params, $context);
    }
}