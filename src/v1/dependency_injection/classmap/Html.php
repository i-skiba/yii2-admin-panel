<?php

namespace yii\helpers;

use Yii;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;

/**
 * Вспомогательный класс для формирование html элементов
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Html extends BaseHtml
{
    /**
     * Кнопка сохранения с редиректом на список
     *
     * @param string|null $content
     * @param array $options
     * @return string HTML
     */
    public static function saveRedirectButton($content = null, $options = [])
    {
        if(! $content) {
            $content = '<b><i class="icon-list"></i></b>' . Yii::t('yii2admin', 'Сохранить и перейти к списку');
        }

        $defaultActions =     [
            'class' => 'btn bg-info btn-labeled btn-labeled-left ml-1',
        ];
        $options = ArrayHelper::merge($options, $defaultActions);
        $options['type'] = 'submit';
        $options['name'] = RequestHelper::REDIRECT_BTN_PARAM;
        $options['value'] = 'index';
        $options['class'] .= (RequestHelper::isMagicModal() ? ' d-none' : null);

        return static::button($content, $options);
    }

    /**
     * Кнопка сохранения
     *
     * @param string|null $content
     * @param array $options
     * @return string HTML
     */
    public static function saveButton($content = null, $options = [])
    {
        if(! $content) {
            $content = '<b><i class="icon-checkmark3"></i></b>' . Yii::t('yii2admin', 'Сохранить');
        }

        $defaultActions =     [
            'class' => 'btn bg-success btn-labeled btn-labeled-left ml-1',
        ];
        $options = ArrayHelper::merge($options, $defaultActions);
        $options['type'] = 'submit';

        return static::button($content, $options);
    }
}