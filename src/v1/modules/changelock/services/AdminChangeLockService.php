<?php

namespace kamaelkz\yii2admin\v1\modules\changelock\services;

use kamaelkz\yii2admin\v1\modules\changelock\forms\AdminChangeLockForm;
use Yii;
use concepture\yii2logic\services\Service;
use yii\helpers\Url;

/**
 * Class AdminChangeLockService
 * @package kamaelkz\yii2admin\v1\modules\hints\services
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class AdminChangeLockService extends Service
{
    /**
     * Обновить блок урла
     * @param $url
     * @return \concepture\yii2logic\models\ActiveRecord|mixed
     */
    public function updateUrl($url)
    {
        $currentDt = $this->getCurrent();
        $serialized = serialize($currentDt);
        $lock = $this->getOneByCondition(['url' => $url]);
        if (! $lock){
            $form = new AdminChangeLockForm();
            $form->url = $url;
            $form->session_id = Yii::$app->session->getId();
            $form->user_id = Yii::$app->user->identity->id;
            $form->last_acess_date_time = date("Y-m-d H:i:s");
            $form->last_access = $serialized;
            $lock = $this->create($form);

            return $lock;
        }

        $lock->session_id = Yii::$app->session->getId();
        $lock->last_acess_date_time = date("Y-m-d H:i:s");
        $lock->user_id = Yii::$app->user->identity->id;
        $lock->last_access = $serialized;
        $lock->save(false);

        return $lock;
    }

    /**
     * Прроверить блок урла
     * @param $url
     * @return \concepture\yii2logic\models\ActiveRecord|mixed
     */
    public function checkUrl($url)
    {
        $currentDt = $this->getCurrent();
        $serialized = serialize($currentDt);
        $lock = $this->getOneByCondition(['url' => $url]);
        if (! $lock){
            $form = new AdminChangeLockForm();
            $form->url = $url;
            $form->session_id = Yii::$app->session->getId();
            $form->user_id = Yii::$app->user->identity->id;
            $form->last_acess_date_time = date("Y-m-d H:i:s");
            $form->last_access = $serialized;
            $lock = $this->create($form);

            return true;
        }

        $lockDt = unserialize($lock->last_access);
        $diffSec = $currentDt->getTimestamp() - $lockDt->getTimestamp();
        if ($diffSec > 30 || $lock->session_id == Yii::$app->session->getId()){
            $lock->session_id = Yii::$app->session->getId();
            $lock->last_acess_date_time = date("Y-m-d H:i:s");
            $lock->last_access = $serialized;
            $lock->user_id = Yii::$app->user->identity->id;
            $lock->save(false);

            return true;
        }

        if ($lock->user_id == Yii::$app->user->identity->id) {
            return true;
        }

        return $lock;
    }

    /**
     * Возвращает обьект теукщего даты / времени
     */
    public function getCurrent()
    {
        $dtString = date("Y-m-d H:i:s");
        $format = 'Y-m-d H:i:s';

        return \DateTimeImmutable::createFromFormat($format, $dtString);
    }
}