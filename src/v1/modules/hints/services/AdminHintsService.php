<?php

namespace kamaelkz\yii2admin\v1\modules\hints\services;

use concepture\yii2logic\enum\StatusEnum;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\base\Event;
use yii\helpers\Json;
use concepture\yii2handbook\services\LocaleService;
use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2logic\forms\Model;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2handbook\services\traits\ModifySupportTrait as HandbookModifySupportTrait;
use concepture\yii2handbook\services\traits\ReadSupportTrait as HandbookReadSupportTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;
use concepture\yii2user\services\UserService;
use kamaelkz\yii2admin\v1\modules\hints\widgets\Bundle;
use kamaelkz\yii2admin\v1\modules\hints\widgets\HintWidget;
use kamaelkz\yii2admin\v1\themes\components\view\View;

/**
 * Сервис для работы с подсказками
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class AdminHintsService extends \concepture\yii2logic\services\Service
{
    use StatusTrait;
    use HandbookModifySupportTrait;
    use HandbookReadSupportTrait;
    use LocalizedReadTrait;

    /**
     * @var array
     */
    private $stack= [];

    /**
     * @var array
     */
    private $existsItems = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->registerEvents();
    }

    /**
     * @return LocaleService
     */
    public function getLocaleService()
    {
        return Yii::$app->localeService;
    }

    /**
     * @return UserService
     */
    public function getUserRoleService()
    {
        return Yii::$app->userRoleService;
    }

    /**
     * @inheritDoc
     */
    public function beforeModelSave(Model $form, ActiveRecord $model, $is_new_record)
    {
        $form->name = strtoupper($form->name);
        parent::beforeModelSave($form, $model, $is_new_record);
    }

    /**
     * @inheritDoc
     */
    public function getDataProvider($queryParams = [], $config = [], $searchModel = null, $formName = null, $condition = null)
    {
        # показываем в списке только записи с заполненым caption
        if(! $condition) {
            $condition = function(ActiveQuery $query) {
                $user_id = Yii::$app->getUser()->getId();
                $roles = $this->getUserRoleService()->getRolesByUserId($user_id);
                if(! isset($roles[UserRoleEnum::SUPER_ADMIN])) {
                    $class  = $this->getRelatedModelClass();
                    $alias = $class::localizationAlias();
                    $query->andWhere("{$alias}.caption IS NOT NULL");
                };

                $query->orderBy(['id' => SORT_ASC]);
            };
        }

        return parent::getDataProvider($queryParams, $config, $searchModel, $formName, $condition);
    }

    /**
     * Добавляет подсказку в стэк
     *
     * @param $item
     */
    public function pushStack(HintWidget $item)
    {
        $this->stack[$item->name] = $item;
    }


    /**
     * Регистрация событий
     */
    private function registerEvents()
    {
        Event::on(View::class, View::EVENT_END_PAGE, function($event) {
            $this->setExistsItems();
            $this->flushStack();
            $this->registerJs();
        });
    }

    /**
     * Записывает новые подсказки в бд
     */
    private function flushStack()
    {
        if(! $this->stack) {
            return;
        }

        $insertItems = array_diff_key($this->stack, $this->existsItems);
        if(! $insertItems) {
            return;
        }

        foreach ($insertItems as $item) {
            $config = [
                'class' => $this->getRelatedFormClass(),
                'name' => $item->name,
                'locale' => $this->getLocaleService()->getCurrentLocaleId()
            ];
            if($item->caption) {
                $config['caption'] = $item->caption;
            }

            $form = Yii::createObject($config);
            $result = $this->create($form);
            if(! $result) {
                throw new InvalidConfigException("Write stack failed, name: {$form->name}");
            }
        }

        $this->stack = [];
    }

    /**
     * Установка существующих элементов
     */
    private function setExistsItems()
    {
        if(! $this->stack || $this->existsItems) {
            return ;
        }

        $names = array_keys($this->stack);
        $this->existsItems = $this->getAllByCondition(function(ActiveQuery $query) use ($names) {
            $query->andWhere(['name' => $names]);
            $query->indexBy('name');
        });
    }

    /**
     * Регистрация js скрипта
     *
     * @param string $form_id
     */
    private function registerJs()
    {
        if(! $this->existsItems) {
            return;
        }

        $items = [];
        foreach ($this->existsItems as $item) {
            if(
                ! $item['caption']
                || ! $item['value']
                || $item['status'] !== StatusEnum::ACTIVE
            ) {
                continue;
            }

            $items[$item['name']] = [
                'name' => $item['name'],
                'caption' => $item['caption'],
                'value' => nl2br($item['value']),
            ];
        }

        if(! $items) {
            return;
        }

        Bundle::registerJs(Json::encode($items));
    }
}
