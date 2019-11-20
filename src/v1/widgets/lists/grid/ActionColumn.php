<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use Yii;
use yii\helpers\Html;
use yii\grid\ActionColumn as BaseColumn;

/**
 * Колонка действий для грида
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ActionColumn extends BaseColumn
{
    /**
     * {@inheritdoc}
     */
    public $headerOptions = [
        'class' => 'text-center'
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
    public $template = '<div class="list-icons">{view} {update} {delete}</div>';

    /**
     * {@inheritdoc}
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'info22');
        $this->initDefaultButton('update', 'pencil5');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
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
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'class' => 'list-icons-item'
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "icon-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}