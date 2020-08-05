<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\traits;

use Yii;
use yii\helpers\Html;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;

/**
 * Трейт для ListView и GridView
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
trait ListsTrait
{
    /**
     * @var bool
     */
    public $wrapForm = false;

    /**
     * Виджет оборачивается в форму
     *
     * @todo : временно убираем
     *
     * @return string HTML
     */
    public function renderItems()
    {
        $result = null;
        $table = parent::renderItems();
        if(RequestHelper::isMagicModal()) {
            $result .= Html::beginForm(
                    RequestHelper::getCopyFormUrl(),
                    'post',
                    [
                        'class' => 'copy-column-form',
                    ]
            );
            $result.= <<<HTML
<div class="datatable-header p-0 pb-3 pt-3 text-right">
    {$this->getSubmitControll()}
</div>
HTML;
        }

        $result .= $table;

        $result .= <<<HTML
<div class="datatable-footer p-0 pt-3 text-right">
    {$this->getSubmitControll()}
</div>
HTML;
        if(RequestHelper::isMagicModal()) {
            $result .= Html::endForm();
        }

        return $result;
    }
      
    /**
     * Возвращает элемент сабмита формы
     * 
     * @return string
     */
    protected function getSubmitControll()
    {
        if(! RequestHelper::isMagicModal()) {
            return false;
        }
        
        $result = Html::submitButton(
            '<b><i class="icon-checkmark"></i></b>' . Yii::t('yii2admin', 'Выбрать'),
            [
                'class' => 'btn bg-success btn-labeled btn-labeled-left ml-1 copy-column-controll',
            ]
        );
         
        return Html::tag(
            'div',
            $result,
            [
                'class' => 'col-md-12',
                'style' => 'display:block'
            ]
        );
    }
}