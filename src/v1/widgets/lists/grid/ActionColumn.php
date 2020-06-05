<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use concepture\yii2logic\enum\StatusEnum;
use concepture\yii2logic\helpers\AccessHelper;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\grid\ActionColumn as BaseColumn;
use yii\helpers\Url;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use concepture\yii2logic\enum\IsDeletedEnum;

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
        $this->initDefaultButton('activate', 'checkmark4');
        $this->initDefaultButton('deactivate', 'cross2');
        $this->initDefaultButton('delete', 'trash');
        $this->initDefaultButton('undelete', 'redo');
    }

    private function deleted($model) {
        if(! isset($model['is_deleted'])) {
            return true;
        }

        return ($model['is_deleted'] !== IsDeletedEnum::DELETED);
    }

    private function active($model) {
        if(! isset($model['status'])) {
            return true;
        }

        return ($model['status'] !== StatusEnum::INACTIVE);
    }

    /**
     * @param Model $model
     * @param array $url
     * @return bool
     */
    private function setUrlLocale($model, &$url)
    {
        if(! isset($model['locale'])) {
            return true;
        }

        if(is_array($url)) {
            $url['locale'] = $model['locale'];
        } else {
            @list($path, $query) = array_values(parse_url($url));
            $query .= "&locale={$model['locale']}";

            $url = "{$path}?{$query}";
        }

        return true;
    }

    /**
     * {@inheritdoc}
     * @todo : рефактор
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (! isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                $visible = true;
                switch ($name) {
                    case 'update':
                        $title = Yii::t('yii2admin', 'Редактировать');
                        $visible = ! $this->deleted($model);
                        break;
                    case 'view':
                        $title = Yii::t('yii2admin', 'Просмотр');
                        # todo: костылина, для последнего условия, привести в порядок
                        $visible = false;
                        break;
                    case 'activate':
                        $title = Yii::t('yii2admin', 'Активировать');
                        $url = ['status-change', 'id' => $model['id'], 'status' => StatusEnum::ACTIVE];
                        $visible = (! $this->deleted($model) || $this->active($model));
                        $additionalOptions = [
                            'class' => ($this->dropdown ? 'dropdown-item' : 'list-icons-item') . ' admin-action',
                            'data-pjax-id' => Pjax::DEFAULT_ID,
                            'data-pjax-url' => Url::current([], true),
                            'data-swal' => $title,
                        ];
                        break;
                    case 'deactivate':
                        $title = Yii::t('yii2admin', 'Деактивировать');
                        $url = ['status-change', 'id' => $model['id'], 'status' => StatusEnum::INACTIVE];
                        $visible = (! $this->deleted($model) || ! $this->active($model));
                        $additionalOptions = [
                            'class' => ($this->dropdown ? 'dropdown-item' : 'list-icons-item') . ' admin-action',
                            'data-pjax-id' => Pjax::DEFAULT_ID,
                            'data-pjax-url' => Url::current([], true),
                            'data-swal' => $title,
                        ];
                        break;
                    case 'delete':
                        $title = Yii::t('yii2admin', 'Удалить');
                        $visible = ! $this->deleted($model);
                        $additionalOptions = [
                            'class' => ($this->dropdown ? 'dropdown-item' : 'list-icons-item') . ' admin-action',
                            'data-pjax-id' => Pjax::DEFAULT_ID,
                            'data-pjax-url' => Url::current([], true),
                            'data-swal' => $title,
                        ];
                        break;
                    case 'undelete':
                        $visible = $this->deleted($model);
                        $title = Yii::t('yii2admin', 'Восстановить');
                        $additionalOptions = [
                            'class' => ($this->dropdown ? 'dropdown-item' : 'list-icons-item') . ' admin-action',
                            'data-pjax-id' => Pjax::DEFAULT_ID,
                            'data-pjax-url' => Url::current([], true),
                            'data-swal' => $title,
                        ];
                        break;
                    default:
                        $title = ucfirst($name);
                }

                $this->setUrlLocale($model, $url);
                $options = array_merge(
                    [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => '0',
                        'class' => $this->dropdown ? 'dropdown-item' : 'list-icons-item',
                        'visible' => false
                    ],
                    $additionalOptions,
                    $this->buttonOptions
                );
                $icon = Html::tag('i', '', ['class' => "icon-$iconName"]);
                $label = $this->dropdown ? ($icon . $title) : $icon;

                if(! $visible !== false) {
                    return Html::a($label, $url, $options);
                }
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
            if (! AccessHelper::checkAccess($name, ['model' => $model])){
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
            if(! $this->template) {
                $this->template = '{update} {activate} {deactivate} {delete} {undelete}';
            }
//            if($this->template === '{view} {update} {delete}') {
//                $this->template = '{view} {update}<div class="dropdown-divider"></div>{delete}';
//            }
        }
    }
}