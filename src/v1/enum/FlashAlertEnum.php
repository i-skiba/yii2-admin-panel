<?php

namespace kamaelkz\yii2admin\v1\enum;

use concepture\yii2logic\enum\Enum;

/**
 * Типы всплывающих уведомлений
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class FlashAlertEnum extends Enum
{
    const PRIMARY = 'primary';
    const SUCCESS = 'success';
    const ERROR = 'danger';
    const WARNING = 'warning';
    const INFO = 'info';
}