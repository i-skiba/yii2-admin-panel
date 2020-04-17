<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use concepture\yii2user\helpers\AccessHelper;
use Yii;
use yii\helpers\Html;
use yii\grid\ActionColumn as BaseColumn;
use yii\helpers\Url;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;

/**
 * Колонка действий для грида
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ActionColumn extends BaseColumn
{
    /**
     * @var bool элементы управления - выпадающий список
     */
    public $dropdown = true;

    /**
     * {@inheritdoc}
     */
    public $headerOptions = [
        'class' => 'text-center',
    ];

    /**
     * {@inheritdoc}
     */
    public $contentOptions = [
        'class' => 'text-center'
    ];

    /**
     * {@inheritdoc}
     */
    protected function initDefaultButtons()
    {
        $this->setDefaultSettings();
        $this->initDefaultButton('view', 'file-eye2');
        $this->initDefaultButton('update', 'pencil6');
        $this->initDefaultButton('delete', 'bin2', [
            'class' => ($this->dropdown ? 'dropdown-item' : 'list-icons-item') . ' admin-action',
            'data-pjax-id' => Pjax::DEFAULT_ID,
            'data-pjax-url' => Url::current([], true),
            'data-swal' => Yii::t('yii2admin' , 'Удалить'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii2admin', 'Просмотр');
                        break;
                    case 'update':
                        $title = Yii::t('yii2admin', 'Редактировать');
                        break;
                    case 'delete':
                        $title = Yii::t('yii2admin', 'Удалить');
                        break;
                    default:
                        $title = ucfirst($name);
                }

                $options = array_merge(
                    [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => '0',
                        'class' => $this->dropdown ? 'dropdown-item' : 'list-icons-item'
                    ],
                    $additionalOptions,
                    $this->buttonOptions
                );
                $icon = Html::tag('i', '', ['class' => "icon-$iconName"]);
                $label = $this->dropdown ? ($icon . $title) : $icon;

                return Html::a($label, $url, $options);
            };
        }
    }

    /**
     * @inheritDoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        /**
         * Копия оригинального метода для проверки прав доступа
         */
        $content = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            /**
             * Все сделано ради этой проверки
             * если нет доступа то кнопки нет
             */
            if (! AccessHelper::checkAccess($name)){
                return '';
            }

            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure
                    ? call_user_func($this->visibleButtons[$name], $model, $key, $index)
                    : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }

            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            }

            return '';
        }, $this->template);

        if(! $this->dropdown) {
            return <<<HTML
            <div class="list-icons">
                $content
            </div>
HTML;
        }

        return <<<HTML
            <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-cog5"></i>
                    </a>
                    <div class="dropdown-menu">
<!--                        <div class="dropdown-header">$this->header</div>-->
                        $content
                    </div>
                </div>
            </div>
HTML;

    }

    /**
     * Установка кастомных настроек
     */
    private function setDefaultSettings()
    {
        $this->header = Yii::t('yii2admin', 'Операции');
        if($this->dropdown) {
            $this->headerOptions['style'] = 'width : 15%';
            if($this->template === '{view} {update} {delete}') {
                $this->template = '{view} {update}<div class="dropdown-divider"></div>{delete}';
            }
        }
    }
}