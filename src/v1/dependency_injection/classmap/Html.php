<?php

namespace yii\helpers;

use kamaelkz\yii2admin\v1\modules\hints\widgets\HintWidget;
use Yii;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;

/**
 * Вспомогательный класс для формирование html элементов
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Html extends BaseHtml
{
    const FIELD_TEXT_INPUT = 'textInput';
    const FIELD_HIDDEN_INPUT = 'hiddenInput';
    const FIELD_PASSWORD_INPUT = 'passwordInput';
    const FIELD_TEXT_AREA = 'textarea';
    const FIELD_RADIO = 'radio';
    const FIELD_CHECKBOX = 'checkbox';
    const FIELD_DROPDOWN = 'dropDownList';
    const FIELD_WIDGET = 'widget';

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

    /**
     * @inheritDoc
     */
    public static function activeLabel($model, $attribute, $options = [])
    {
        $name = Inflector::underscore($model->formName(), '-') . "_" . Inflector::underscore($attribute, '-');
        $for = ArrayHelper::remove($options, 'for', static::getInputId($model, $attribute));
        $attribute = static::getAttributeName($attribute);
        $label = ArrayHelper::remove($options, 'label', static::encode($model->getAttributeLabel($attribute)));
        $hint = HintWidget::widget(['name' => $name]);
        $label = "{$label} {$hint}";

        return static::label($label, $for, $options);
    }
}