<?php

namespace kamaelkz\yii2admin\v1\widgets\notifications\alert;

use Yii;
use concepture\yii2logic\widgets\Widget;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
use yii\base\InvalidConfigException;

/**
 * Виджет уведомлений bootrtrap
 *
 * @property string $type
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Alert extends Widget
{
    /**
     * @var string тип сообщения
     */
    public $type;

    /**
     * @var string сообщение
     */
    public $message;

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
        $message = $this->message;
        if(! $message ) {
            throw new InvalidConfigException('Message must be set.');

            return null;
        }

        return $this->render('view', [
            'type' => $this->type,
            'label' => $closeLabel,
            'message' => $message,
        ]);
    }
}