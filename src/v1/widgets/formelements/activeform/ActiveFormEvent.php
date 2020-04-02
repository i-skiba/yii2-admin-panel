<?php

namespace kamaelkz\yii2admin\v1\widgets\formelements\activeform;

use yii\base\Event;
use yii\base\Model;

/**
 * Событие формы
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ActiveFormEvent extends Event
{
    /**
     * @var Model
     */
    public $model;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }
}