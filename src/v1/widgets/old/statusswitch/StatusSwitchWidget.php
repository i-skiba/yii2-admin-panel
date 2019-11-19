<?php

namespace frontend\common\components\widgets\statusswitch;

use Yii;
use yii\helpers\Html;
use frontend\common\helpers\Url;
use yii\base\InvalidConfigException;

/**
 * Виджет формирует элементы для переключения
 * 
 * @property array[SwitchItem] $items - элементы переключателя
 * @property boolean $visible - признак отображения виджета
 * 
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class StatusSwitchWidget extends \yii\base\Widget
{
    /**
     * Массив элементов переключателя
     * 
     * @var array[SwitchItem] 
     */
    public $items = [];
    /**
     * Признак отображения виджета
     * 
     * @var boolean
     */
    public $visible = true;
    /**
     * Css класс активного элемента
     * 
     * @var string
     */
    public static $activeClass = 'active';

    public function init()
    {
        $this->setMagicModalSettings();
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        if(! $this->visible) {
            return;
        }
        parent::run();
        $this->isCorrectItems();
        
        return $this->render('view', [
            'items' => $this->items
        ]);
    }

    /**
     * Проверка корректности элементов массива $items
     * 
     * @throws InvalidConfigException
     */
    private function isCorrectItems()
    {
        if(! $this->items || !is_array($this->items)) {
            throw new InvalidConfigException('$items empty or is not array.');
        }
        foreach ($this->items  as $item) {
            if($item instanceof SwitchItem) {
                continue;
            }
            throw new InvalidConfigException('$items elements must be instance of SwitchItem');
        }
    }
     
    /**
     * Настройки для магической модалки
     */
    private function setMagicModalSettings()
    {
        $pjaxParam = Yii::$app->request->get('_pjax');
        if($pjaxParam && $pjaxParam == '#magic-modal-pjax') {
            $this->visible = false;
        }
    }
}

class SwitchItem
{
    /**
     * Признак активного элемента
     * 
     * @var boolean
     */
    private $_is_active;
    /**
     * Роут для перенаправления
     * 
     * @var array 
     */
    private $_route;
    /**
     * Метка переключателя
     * 
     * @var string 
     */
    private $_label;
    
    public function __construct(bool $is_active, array $route, string $label) 
    {
        $this->setIsActive($is_active);
        $this->setRoute($route);
        $this->setLabel($label) ;
    }
    
    /**
     * Возвращает экземпляр класса
     * 
     * @param bool $is_active
     * @param array $route
     * @param string $label
     * @return \self
     */
    public static function getInstance(bool $is_active, array $route, string $label)
    {
        return new self($is_active, $route, $label);
    }

    private function setIsActive(bool $v)
    {
        $this->_is_active = ((bool) $v ? StatusSwitchWidget::$activeClass : null);
    }
    
    private function setRoute( array $v)
    {
        $this->_route = Url::toRoute($v);
    }
    
    private function setLabel(string $v)
    {
        $this->_label = Html::decode($v);
    }

    public function getIsActive()
    {
        return $this->_is_active;
    }
    
    public function getRoute() : string
    {
        return $this->_route;
    }
    
    public function getLabel() : string
    {
        return $this->_label;
    }
}