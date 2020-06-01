<?php

namespace kamaelkz\yii2admin\v1\modules\uikit\forms;

use Yii;
use kamaelkz\yii2admin\v1\forms\BaseModel;
use kamaelkz\yii2admin\v1\modules\uikit\enum\UiikitEnum;
use concepture\yii2logic\validators\ModelValidator;
use kamaelkz\yii2cdnuploader\pojo\CdnImagePojo;

/**
 * Форма для UIkit
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class UikitForm extends BaseModel
{
    public $id;
    public $image;
    public $image_local;
    public $mask;
    public $text_input;
    public $text_area;
    public $editor;
    public $checkbox_standart;
    public $checkbox_switch;
    public $date_picker;
    public $time_picker;
    public $dropdown;
    public $dropdown_root;
    public $dropdown_depend;
    public $dropdown_depend_2;
    public $radio;
    public $checkboxList = [];
    public $multiInput = [];
    public $select2;
    public $hint_input;

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[UiikitEnum::SCENARIO_DEPEND_SELECTS] = $this->attributes();

        return $scenarios;
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
                            'radio',
                            'select2',
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
                            'text_area',
                            'hint_input'
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
                            'multiInput',
                        ],
                        'each',
                        'rule' => ['string'],
                    ],
                    [
                        [
                            'checkboxList',
                        ],
                        'each',
                        'rule' => ['integer'],
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
                            'image_local'
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
            'image' => 'Изображение',
            'image_local' => 'Изображение (локальная загрузка)',
            'text_input' => Yii::t('yii2admin', 'Текстовое поле'),
            'text_area' => Yii::t('yii2admin', 'Многострочное текстовое поле'),
            'mask' => Yii::t('yii2admin', 'Маска'),
            'editor' => Yii::t('yii2admin', 'Редактор'),
            'checkbox_standart' => Yii::t('yii2admin', 'Чекбокс стандартный'),
            'checkbox_switch' => Yii::t('yii2admin', 'Чекбокс хитрый'),
            'multiInput' => Yii::t('yii2admin', 'Мульти текстовое поле'),
            'date_picker' => Yii::t('yii2admin', 'Выбор даты'),
            'time_picker' => Yii::t('yii2admin', 'Выбор времени'),
            'dropdown' => Yii::t('yii2admin', 'Выпадающее меню'),
            'dropdown_root' => Yii::t('yii2admin', 'Управляющий элемент'),
            'dropdown_depend' => Yii::t('yii2admin', 'Зависимые элементы 1'),
            'dropdown_depend_2' => Yii::t('yii2admin', 'Зависимый элемент 2'),
            'checkboxList' => Yii::t('yii2admin', 'Набор чекбоксов'),
            'radio' => Yii::t('yii2admin', 'Набор радиобатонов'),
            'select2' => Yii::t('yii2admin', 'Раскрывающийся список Select2'),
        ];
    }
//
//    public function attributeHints()
//    {
//        return [
//            'image' => 'test hint'
//        ];
//    }
}