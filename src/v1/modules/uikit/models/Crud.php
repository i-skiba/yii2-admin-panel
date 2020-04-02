<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\models;

use Yii;
use kamaelkz\yii2cdnuploader\pojo\CdnImagePojo;
use kamaelkz\yii2admin\v1\modules\uikit\enum\UiikitEnum;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\validators\ModelValidator;

/**
 * Модель CRUD
 *
 * @property integer $id
 * @property string $image
 * @property string $image_local
 * @property string $mask
 * @property string $text_input
 * @property string $text_area
 * @property string $editor
 * @property boolean $checkbox_standart
 * @property boolean $checkbox_switch
 * @property string $date_picker
 * @property string $time_picker
 * @property integer $dropdown
 * @property integer $dropdown_root
 * @property integer $dropdown_depend
 * @property integer $dropdown_depend_2
 * @property integer $radio
 * @property integer $sort
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class Crud extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[UiikitEnum::SCENARIO_DEPEND_SELECTS] = $this->attributes();

        return $scenarios;
    }

    public static function label()
    {
        return 'Интерфейс';
    }

    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'yii2_admin_crud';
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [
                [
                    'editor',
                    'image',
                    'text_input',
                    'text_area',
                    'mask',
                    'checkbox_standart',
                    'checkbox_switch',
                    'date_picker',
                    'time_picker',
                    'dropdown',
                    'dropdown_root',
                    'radio'
                ],
                'required',
            ],
            [
                [
                    'dropdown_depend',
                    'dropdown_depend_2',
                ],
                'required',
                'on' => UiikitEnum::SCENARIO_DEPEND_SELECTS
            ],
            [
                [
                    'text_input',
                    'text_area'
                ],
                'string',
                'max' => 50
            ],
            [
                [
                    'text_input',
                    'editor',
                    'text_area'
                ],
                'string'
            ],
            [
                [
                    'checkbox_standart',
                    'checkbox_switch',
                ],
                'boolean',
            ],
            [
                [
                    'checkbox_standart',
                    'checkbox_switch',
                ],
                'compare',
                'compareValue' => true,
                'operator' => '==',
                'message' => Yii::t('yii2admin', 'Необходимо принять чекбокс, как должное.')
            ],
            [
                [
                    'date_picker',
                ],
                'date',
                'format' => Yii::$app->formatter->dateFormat
            ],
            [
                [
                    'time_picker',
                ],
                'date',
                'format' => Yii::$app->formatter->timeFormat
            ],
            [
                [
                    'dropdown',
                    'dropdown_root',
                    'dropdown_depend',
                    'dropdown_depend_2',
                    'radio'
                ],
                'integer'
            ],
            [
                [
                    'image',
                    'image_local',
                ],
                'string'
            ],
            [
                [
                    'image',
                    'image_local'
                ],
                ModelValidator::class,
                'modelClass' => CdnImagePojo::class,
                'modifySource' => false,
                'message' => Yii::t('yii2admin', 'Некорректный формат данных.')
            ]
        ];
    }

    /**
     * @inheritDoc
     * @see \kamaelkz\yii2admin\v1\forms\BaseForm `validate` function
     */
    public function beforeValidate()
    {
        if($this->dropdown_root == UiikitEnum::DEPEND_CHANGE_VALUE) {
            $this->setScenario(UiikitEnum::SCENARIO_DEPEND_SELECTS);
        }

        return parent::beforeValidate();
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'image' => 'Изображение',
            'image_local' => 'Изображение (локальная загрузка)',
            'text_input' => Yii::t('yii2admin', 'Текстовое поле'),
            'text_area' => Yii::t('yii2admin', 'Многострочное текстовое поле'),
            'mask' => Yii::t('yii2admin', 'Маска'),
            'editor' => Yii::t('yii2admin', 'Редактор'),
            'checkbox_standart' => Yii::t('yii2admin', 'Чекбокс стандартный'),
            'checkbox_switch' => Yii::t('yii2admin', 'Чекбокс хитрый'),
            'date_picker' => Yii::t('yii2admin', 'Выбор даты'),
            'time_picker' => Yii::t('yii2admin', 'Выбор времени'),
            'dropdown' => Yii::t('yii2admin', 'Выпадающее меню'),
            'dropdown_root' => Yii::t('yii2admin', 'Управляющий элемент'),
            'dropdown_depend' => Yii::t('yii2admin', 'Зависимые элементы 1'),
            'dropdown_depend_2' => Yii::t('yii2admin', 'Зависимый элемент 2'),
            'radio' => Yii::t('yii2admin', 'Набор радиобатонов'),
            'sort' => Yii::t('yii2admin', 'Сортировка'),
        ];
    }
}