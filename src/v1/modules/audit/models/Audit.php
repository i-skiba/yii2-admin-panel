<?php

namespace kamaelkz\yii2admin\v1\modules\audit\models;

use concepture\yii2logic\models\ActiveRecord;

/**
 * Class Audit
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property string $model
 * @property integer $model_pk
 * @property string $field
 * @property string $old_value
 * @property string $new_value
 * @property string $created_at
 *
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class Audit extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%audit}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'user_id',
                    'action',
                    'model',
                    'model_pk',
                    'field',
                ],
                'required',
            ],
            [
                [
                    'id',
                    'user_id',
                ],
                'integer',
            ],
            [
                [
                    'action',
                    'model',
                    'field',
                    'model_pk',
                ],
                'string',
                'max' => 256,
            ],
            [
                [
                    'old_value',
                    'new_value',
                    'created_at',
                ],
                'string',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'user_id' => \Yii::t('common', 'Пользователь'),
            'action' => \Yii::t('common', 'Действие'),
            'model' => \Yii::t('common', 'Модель'),
            'model_pk' => \Yii::t('common', 'Первичный ключ'),
            'field' => \Yii::t('common', 'Поле'),
            'old_value' => \Yii::t('common', 'Старое значение'),
            'new_value' => \Yii::t('common', 'Новое значение'),
            'created_at' => \Yii::t('common', 'Дата создания'),
        ];
    }

    /**
     * @return mixed
     */
    public function getDiffHtml()
    {
        $old = explode("\n", $this->old_value);
        $new = explode("\n", $this->new_value);

        foreach ($old as $i => $line) {
            $old[$i] = rtrim($line, "\r\n");
        }
        foreach ($new as $i => $line) {
            $new[$i] = rtrim($line, "\r\n");
        }

        $diff = new \Diff($old, $new);
        return $diff->render(new \Diff_Renderer_Html_Inline);
    }
}
