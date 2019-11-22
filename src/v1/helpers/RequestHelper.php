<?php

namespace kamaelkz\yii2admin\v1\helpers;

use Yii;

/**
 * Вспомогательный класс для работы HTTP запросами
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class RequestHelper
{
    const COPY_FORM_URL_PARAM = '_copy_from_url';
    const COPY_IDS_PARAM = '_copy_ids';
    
    /**
     * Проверка на запрос из магической модалки
     * 
     * @return bool
     */
    public static function isMagicModal() : bool
    {
        return (($param = Yii::$app->request->get('_pjax')) && $param == '#magic-modal-pjax');
    }
    
    /**
     * Получение параметра адреса формы для копирования
     * 
     * @return string
     */
    public static function getCopyFormUrl() : string
    {
        return Yii::$app->request->get(self::COPY_FORM_URL_PARAM, '');
    }
}
