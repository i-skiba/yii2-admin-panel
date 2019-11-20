<?php

namespace kamaelkz\yii2admin\v1\widgets\notifications\alert;

use Yii;
use concepture\yii2logic\widgets\Widget;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;

/**
 * Виджет уведомлений bootrtrap
 * 
 * @property string $type
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class FlashAlert extends Widget
{
    /**
     * @var string тип сообщения
     */
    public $type;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if(! $this->type) {
            $this->type = FlashAlertEnum::SUCCESS;
        }
    }

    /**
     * @inheritDoc
     */
    public function run() 
    {
        $closeLabel = Yii::t('yii2admin','Закрыть');
        $message = Yii::$app->session->getFlash($this->type);
        if(! $message ) {
            return null;
        }

        return $this->render('view', [
            'type' => $this->type,
            'label' => $closeLabel,
            'message' => $message,
        ]);
    }
}