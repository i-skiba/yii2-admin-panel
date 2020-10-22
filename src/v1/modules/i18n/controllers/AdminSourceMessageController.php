<?php

namespace kamaelkz\yii2admin\v1\modules\i18n\controllers;

use Yii;
use kamaelkz\yii2admin\v1\modules\i18n\services\MessageService;
use kamaelkz\yii2admin\v1\modules\i18n\services\SourceMessageService;

/**
 * Контроллер оригиналов переводов
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminSourceMessageController extends \concepture\yii2handbook\web\controllers\SourceMessageController
{
    /**
     * @return MessageService
     */
    protected function getMessageService()
    {
        return Yii::$app->adminMessageService;
    }

    /**
     * @return SourceMessageService
     */
    public function getService()
    {
        return Yii::$app->adminSourceMessageService;
    }
}