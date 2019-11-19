<?php

namespace frontend\common\components\widgets\multilanguageview;

use Yii;
use yii\base\Widget;
use yii\base\Model;
use yii\base\Exception;
use yii\base\InvalidConfigException;

/**
 * Class MultiLangViewWidget
 *
 * Виджет мультиязычных форм
 * При наличии более одного языка оборачивается в табы
 *
 * @property Model $model
 * @property string $viewName - файл представления
 * @property array $viewParams - дополнительные переменные передаваемые на предствление
 *
 * @example :
 * MultiLangFormWidget::widget([
 *     'model' => $model,
 *     'viewName' => 'languages/view'
 * ]);
 *
 * @author Poletayev Evgeniy <evgstn7@gmail.com>
 *
 * @package frontend\common\components\widgets\multilanguageview
 */
class MultiLangViewWidget extends Widget
{
    /** @var Model */
    public $model;
    /** @var string */
    public $viewName = 'languages/view';
    /** @var array */
    public $viewParams;

    /**
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        if(! $this->model || (!$this->model instanceof Model)){
            throw new InvalidConfigException('Атрибут {model} не может быть пустым или не является экземпляром класса yii\base\Model');
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        parent::run();
        $languages = Yii::$app->systemService->getLanguages();
        $defaultLanguage = Yii::$app->systemService->getDefaultLanguage();
        $params = [
            'widget_id' => $this->id,
            'model' => $this->model,
            'languages' => $languages,
            'defaultLanguage' => $defaultLanguage,
            'viewPath' => $this->viewName,
            'viewParams' => []
        ];
        if($this->viewParams) {
            $params['viewParams'] = $this->viewParams;
        }

        return $this->render('view', $params);
    }
}