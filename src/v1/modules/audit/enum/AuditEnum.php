<?php

namespace kamaelkz\yii2admin\v1\modules\audit\enum;

use concepture\yii2logic\enum\Enum;

/**
 * Class AuditEnum
 *
 * @package backend\modules\audit\enum
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class AuditEnum extends Enum
{
    /** @var string */
    const MODULE_NAME = 'audit';
    /** @var string */
    const ACTION_CREATE = 'CREATE';
    /** @var string */
    const ACTION_UPDATE = 'UPDATE';
    /** @var string */
    const ACTION_DELETE = 'DELETE';
}