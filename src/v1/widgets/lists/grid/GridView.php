<?php

namespace kamaelkz\yii2admin\v1\widgets\lists\grid;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView as Base;
use kamaelkz\yii2admin\v1\forms\BaseForm;
use kamaelkz\yii2admin\v1\helpers\RequestHelper;
use kamaelkz\yii2admin\v1\actions\SortAction;

/**
 * Грид для проекта
 *
 * @todo : dragAndDrop и $dragAndDropOptions - как то не красиво
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
     * @var bool признак поиска с разворачивающимся блоком
     */
    public $searchCollapsed = true;

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
        'class' => 'grid-view'
    ];

    /**
     * @var bool
     */
    public $dragAndDrop = false;

    /**
     * @var array
     */
    public $dragAndDropOptions = [
        'column' => 'sort'
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
        $this->initDragAndDrop();
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
            $this->searchParams['searchCollapsed'] = $this->searchCollapsed;
            $this->searchParams['selectedFilterCount'] = $model->getSelectedFilterCount();
        }

        $params = ArrayHelper::merge($this->searchParams, ['searchParams' => $this->searchParams]);
        $this->layout = $this->render('layout', $params);

    }

    /**
     * @inheritDoc
     */
    public function renderTableBody()
    {
        $models = array_values($this->dataProvider->getModels());
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            if ($this->beforeRow !== null) {
                $row = call_user_func($this->beforeRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            $rows[] = $this->renderTableRow($model, $key, $index);

            if ($this->afterRow !== null) {
                $row = call_user_func($this->afterRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }

        if (empty($rows) && $this->emptyText !== false) {
            $colspan = count($this->columns);

            return "<tbody>\n<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>\n</tbody>";
        }

        $options = [];
        if($this->dragAndDrop) {
            $sortColumn = $this->dragAndDropOptions['column'] ?? null;
            if(! $sortColumn) {
                throw new InvalidConfigException('dragAndDropOptions `column` must be set.');
            }

            $options['class'] = 'dnd-grid-view';
            $options['data-url'] = Url::to([SortAction::actionName() , 'sortColumn' => $sortColumn]);
        }

        return Html::tag('tbody', implode("\n", $rows), $options);
    }
    
    /**
     * Настройки грида для магической модалки
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

    /**
     * Инициализация колонки
     */
    private function initDragAndDrop()
    {
        if(! $this->dragAndDrop) {
            return ;
        }

        $column = &$this->columns[0];
        if(is_string($column)) {
            $column = [
                'attribute' => $column,
            ];
        }

        $column['class'] = DragAndDropColumn::class;
    }
}
