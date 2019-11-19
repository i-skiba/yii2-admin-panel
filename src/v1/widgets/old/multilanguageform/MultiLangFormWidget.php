<?php

namespace frontend\common\components\widgets\multilanguageform;

use Yii;
use yii\base\Widget;
use yii\widgets\ActiveForm;
use yii\base\Model;
use yii\base\InvalidConfigException;

/**
 * Фиджет мультиязычных форм
 * При наличии более одного языка форма оборачивается в табы
 * 
 * @property Model $model
 * @property ActiveForm $form
 * @property sring $viewName - файл представления
 * @property array $viewParams - дополнительные переменные передаваемые на предствление
 * 
 * @example :
 *               MultiLangFormWidget::widget([
 *                      'model' => $model,
 *                      'form' => $form,
 *                      'viewName' => 'languages/form'
 *               ]);
 * 
 * @author Kamaelkz <kamaelkz@yandex.kz>
 */
class MultiLangFormWidget extends Widget
{
    public $model;
    
    public $form;
    
    public $viewName = 'languages/form';
    
    public $viewParams;

    public function init()
    {
        parent::init();
        if(! $this->model || (!$this->model instanceof Model)){
            throw new InvalidConfigException('Атрибут {model} не может быть пустым или не является экземпляром класса yii\base\Model');
        }
        if(! $this->form || ! $this->form instanceof ActiveForm){
            throw new InvalidConfigException('Атрибут {form} не может быть пустым или не является экземпляром класса yii\widgets\ActiveForm.');
        }
    }

    public function run()
    {
        parent::run();
        $languages = Yii::$app->systemService->getLanguages();
        $defaultLanguage = Yii::$app->systemService->getDefaultLanguage();
        $params = [
            'widget_id' => $this->id,
            'model' => $this->model,
            'form' => $this->form,
            'languages' => $languages,
            'defaultLanguage' => $defaultLanguage,
            'formViewPath' => $this->viewName,
            'viewParams' => []
        ];
        if($this->viewParams) {
            $params['viewParams'] = $this->viewParams;
        }

        return $this->render('view', $params);
    }
}