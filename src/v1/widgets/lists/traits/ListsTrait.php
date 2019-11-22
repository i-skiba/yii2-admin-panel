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
     * Виджет оборачивается в форму
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
        }

        $result .= $table;
        $result .= $this->getSubmitControll();
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
            '<i class="icon-checkmark"></i> ' . Yii::t('yii2admin', 'Выбрать'),
            [
                'class' => 'btn btn-success copy-column-controll hidden mt-20 mb-20 mr-20 pull-right',
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