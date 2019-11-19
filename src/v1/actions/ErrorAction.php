<?php
namespace kamaelkz\yii2admin\v1\actions;

use Yii;
use yii\base\Action;
use yii\web\HttpException;
use kamaelkz\yii2admin\v1\helpers\AppHelper;

/**
 * Страница ошибок
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ErrorAction extends Action
{
    /**
     * @var stting
     */
    public $viewPath;
    
    public function init()
    {
        parent::init();
        if($this->viewPath) {
            return;
        }

        $this->viewPath = 'error';
    }

    public function run()
    {
        $this->controller->layout = AppHelper::SINGLE_LAYOUT_PATH;
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            $exception = new HttpException(404, Yii::t(yii2admin,'Запрашиваемая страница не существует'));
        }

        $code = $exception->statusCode;
        $title = Yii::t(yii2admin , 'Ошибка {error}' , [ 'error' => $code ]);
        $message = $exception->getMessage();
        $this->controller->view->title = $title;
        $this->controller->view->params['breadcrumbs'] = [
            $this->controller->view->title
        ];
        
        return $this->controller->render( $this->viewPath ,[
            'title' => $title ,
            'message' => $message ,
            'code' => $code ,
        ]);
    }
}

