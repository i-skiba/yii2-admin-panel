<?php

namespace kamaelkz\yii2admin\v1\themes\components\view;

use Yii;
use yii\web\View as Base;

/**
 * Представление шаблона
 *
 * @todo definition пока так, не уверен что будет так
 *
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class View extends Base
{
    /**
     * @var array
     */
    public $definition = [];

    /**
     * @var array кастомные бандлы для подключения на лаяутах
     */
    public $customBundles = [];

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
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->registerCustomBundles();
    }

    /**
     * Регистрация касьтомных бандлов
     */
    public function registerCustomBundles()
    {
        if(! $this->customBundles || ! is_array($this->customBundles)) {
            return;
        }

        foreach ($this->customBundles as $bundle) {
            $bundle::register($this);
        }
    }

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
        $result = $this->getOverrideView($view, $params, $context);
        if($result) {
            return $result;
        }

        return parent::render($view, $params, $context);
    }

    /**
     * Поиск сначало проектного представления, после компонента админки
     *
     * @inheritDoc
     */
    public function renderAjax($view, $params = [], $context = null)
    {
        $result = $this->getOverrideView($view, $params, $context);
        if($result) {
            return $result;
        }

        return parent::renderAjax($view, $params, $context);
    }

    /**
     * Поиск переопределенного представления проекта
     *
     * @param string $view
     * @param array $params
     * @param null $context
     * @return string|null
     */
    protected function getOverrideView($view, $params = [], $context = null)
    {
        $appViewFile = $this->findViewFile($view, $context);
        $defination = $this->getDefinition($appViewFile);
        if(null !== $defination) {
            $appViewFile = $defination;
        }

        if (is_file($appViewFile) && file_exists($appViewFile)) {
            $themeBasePath = $this->theme->basePath;
            $this->theme->setBasePath('@app');
            $result = $this->renderFile($appViewFile, $params, $context);
            $this->theme->setBasePath($themeBasePath);

            return $result;
        }

        return null;
    }

    /**
     * @param stting $viewPath
     * @return bool
     */
    protected function getDefinition($viewPath)
    {
        if(! $this->definition) {
            return null;
        }

        foreach ($this->definition as $from => $to) {
            $from = Yii::getAlias($from);
            $to = Yii::getAlias($to);
            if($from == $viewPath) {
                return $to;
            }

            if(($pos = strpos($viewPath, $from)) !== false) {
                return str_replace($from, $to, $viewPath);
            }
        }

        return null;
    }
}