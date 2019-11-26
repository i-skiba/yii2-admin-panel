<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use Yii;
use yii\base\InvalidConfigException;
use yii\grid\GridView as Base;
use kamaelkz\yii2admin\v1\forms\BaseForm;
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
        $searchForm = null;
        if($this->searchVisible && ! $this->searchParams['model']) {
            throw new InvalidConfigException('The "searchParams model" must be set.');
        }

        if($this->searchVisible) {
            $model = $this->searchParams['model'];
            $viewPath = $this->getView()->context->getViewPath();
            $this->searchParams['searchViewPath'] = "{$viewPath}/{$this->searchView}.php";
            # признак открытой формы поиска
            $this->searchParams['collapsed'] = (Yii::$app->request->get(BaseForm::$refreshParam) === null);
            $this->searchParams['selectedFilterCount'] = $model->getSelectedFilterCount();
        }


        $this->layout = $this->render('layout', $this->searchParams);

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
