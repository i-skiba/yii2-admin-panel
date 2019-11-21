<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use Yii;
use yii\grid\GridView as Base;
use frontend\common\components\columns\CopyColumn;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;

/**
 * Грид для проекта
 * 
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class GridView extends Base
{
    use \kamaelkz\yii2admin\v1\widgets\lists\traits\ListsTrait;
    
    /**
     * @var boolean признак отображения поиска
     */
    public $searchVisible = false;

    /**
     * @var string представление поиска
     */
    public $searchView = '_search';

    /**
     * @var array параметры передаваемы на представление поиска
     */
    public $searchParams = [];

    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'grid-view' # table-responsive
    ];

    /**
     * @inheritdoc
     */
    public $tableOptions = [
        'class' => 'table table-bordered table-striped'
    ];

    /**
     * @inheritdoc
     */
    public $pager = [
        'linkContainerOptions' => [
            'class' => 'page-item'
        ],
        'linkOptions' => [
            'class' => 'page-link'
        ],
        'disabledListItemSubTagOptions' => ['tag' => 'div', 'class' => 'page-link'],
        'nextPageLabel' => '&#8594;',
        'prevPageLabel' => '&#8592',
        'options' => [
            'class' => 'pagination-flat justify-content-center twbs-visible-pages pagination',
        ]
    ];
    
    public function init() 
    {
        $this->setMagicModalSettings();
        $this->prepareLayout();
        parent::init();
    }

    /**
     * Формирование шаблона грида
     */
    protected function prepareLayout()
    {
        $searchBlock = null;
        if($this->searchVisible) {
            $searchBlock = $this->view->render($this->searchView, $this->searchParams);
        }
        $this->layout = <<<HTML
            $searchBlock
            <div class='card admin-grid-box'>
                <div class='datatable-header length-left'>
                    <div class='dataTables_info'>
                        {summary}
                    </div>
                    <div class='dataTables_paginate'>
                        {pager}
                    </div>
                </div>
                {items}
                <div class='datatable-footer info-right'>
                    <div class='dataTables_paginate'>
                        {pager}
                    </div>
                </div>
            </div>
HTML;

    }
    
    /**
     * Настройки грида для магической модалки
     *
     *
     */
    private function setMagicModalSettings()
    {
        if(! RequestHelper::isMagicModal()) {
            return;
        }

        $copyColumn = [
            'header' => Yii::t('yii2admin', "Выбор"),
            'class' => CopyColumn::class,
            'headerOptions' => [
                'style' => 'text-align:center;'
            ],
            'contentOptions' => [
                'style' => 'text-align:center;'
            ]
        ];

        $this->searchVisible = false;
        array_unshift($this->columns, $copyColumn);
        array_pop($this->columns);
    }
}
