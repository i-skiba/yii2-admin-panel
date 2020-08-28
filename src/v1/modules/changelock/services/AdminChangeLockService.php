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
        $lock = $this->getOneByCondition(['url' => $url]);
        if (! $lock){
            $form = new AdminChangeLockForm();
            $form->url = $url;
            $form->session_id = Yii::$app->session->getId();
            $form->user_id = Yii::$app->user->identity->id;
            $form->last_acess_date_time = date("Y-m-d H:i:s");
            $lock = $this->create($form);

            return $lock;
        }

        $lock->session_id = Yii::$app->session->getId();
        $lock->last_acess_date_time = date("Y-m-d H:i:s");
        $lock->user_id = Yii::$app->user->identity->id;
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
        $lock = $this->getOneByCondition(['url' => $url]);
        if (! $lock){
            $form = new AdminChangeLockForm();
            $form->url = $url;
            $form->session_id = Yii::$app->session->getId();
            $form->user_id = Yii::$app->user->identity->id;
            $form->last_acess_date_time = date("Y-m-d H:i:s");
            $lock = $this->create($form);

            return true;
        }

        $current = date("Y-m-d H:i:s");
        $diffSec = round(abs(strtotime($current) - strtotime($lock->last_acess_date_time)),2);
        if ($diffSec > 30 || $lock->session_id == Yii::$app->session->getId()){
            $lock->session_id = Yii::$app->session->getId();
            $lock->last_acess_date_time = date("Y-m-d H:i:s");
            $lock->user_id = Yii::$app->user->identity->id;
            $lock->save(false);

            return true;
        }

        if ($lock->user_id == Yii::$app->user->identity->id) {
            return true;
        }

        return $lock;
    }
}