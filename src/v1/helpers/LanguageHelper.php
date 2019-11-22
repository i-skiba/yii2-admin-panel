<?php

namespace kamaelkz\yii2admin\v1\helpers;

use Yii;

/**
 * Вспомогательный класс для работы с языками
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class LanguageHelper
{
    /**
     * Возвращает iso код языка
     *
     * @param bool $short
     * @param bool $lower некоторые плагины содержат переводы в формате ru_RU
     * @return mixed|string
     */
    public static function getIso($lower = false, $short = false)
    {
        $language = Yii::$app->getFormatter()->language;
        if($short) {
            return substr($language, 0, 2);
        }

        if(! $lower) {
            return $language;
        }

        return str_replace('-', '_', $language);
    }
}