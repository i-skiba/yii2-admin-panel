<?php

namespace kamaelkz\yii2admin\v1\modules\hints\dto;

use Yii;
use yii\base\Model;

/**
 * Объект передачи данных для подсказок
 *
 * @todo: стоит поиграться с базовым DTO
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminHintsDto extends Model
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $caption;

    /**
     * Создание нового объекта
     *
     * @param string $name
     * @param integer $id
     * @return AdminHintsDto|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function make($name, $caption = null)
    {
        return Yii::createObject([
            'class' => self::class,
            'name' => $name,
            'caption' => $caption
        ]);
    }
}