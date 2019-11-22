<?php

namespace kamaelkz\yii2admin\v1\controllers\traits;

use Yii;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Json;
use kamaelkz\yii2admin\v1\widgets\notifications\alert\Alert;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;


/**
 * Трейт реализует функции возврата ответа
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
trait ResponseTrait
{
    /**
     * @param string|null $type
     * @param string|null $message
     *
     * @return string JSON
     */
    public function responseNotify($type = FlashAlertEnum::SUCCESS, $message = null)
    {
        return $this->responseJson([
            'type' => $type,
            'message' => $message ?? $this->getSuccessFlash()
        ]);
    }

    /**
     * @param string|null $type
     * @param string|null $message
     *
     * @return string JSON
     */
    public function responseFlash($type = FlashAlertEnum::SUCCESS, $message = null)
    {
        return $this->responseJson([
            'flash' => Alert::widget([
                'type' => $type,
                'message' => $message ?? $this->getSuccessFlash()
            ]),
        ]);
    }

    /**
     * @param string|array $url
     *
     * @return string JSON
     */
    public function responseRedirect($url)
    {
        return $this->responseJson([
            'redirectUrl' => Url::to($url)
        ]);
    }

    /**
     * @param array $payload
     *
     * @return string
     */
    public function responseJson(array $payload)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $payload;
    }
}