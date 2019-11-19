<?php

namespace kamaelkz\yii2admin\v1\widgets\lists;

use yii\widgets\ListView as Base;

/**
 * Лист для проекта
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class ListView extends Base
{
    use \kamaelkz\yii2admin\v1\widgets\lists\traits\ListsTrait;
    
    public $layout = "{items}{pager}";

    public $itemView = "_list";

    /**
     * @inheritdoc
     */
    public $pager = [
        'nextPageLabel' => '&#8594;',
        'prevPageLabel' => '&#8592',
        'options' => [
            'class' => 'pagination-flat pagination-sm twbs-visible-pages pagination',
        ]
    ];
}
