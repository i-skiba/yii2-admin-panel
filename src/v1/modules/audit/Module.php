<?php

namespace kamaelkz\yii2admin\v1\modules\audit;

use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\base\BootstrapInterface;
use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2logic\services\Service;
use kamaelkz\yii2admin\v1\modules\audit\models\Audit;
use kamaelkz\yii2admin\v1\modules\Module as BaseModule;
use kamaelkz\yii2admin\v1\modules\audit\services\AuditService;

/**
 * Class Module
 */
class Module extends BaseModule implements BootstrapInterface
{
    /** @var array */
    public $allowedRoles = [
        UserRoleEnum::SUPER_ADMIN
    ];
    /** @var array Модели разрешенные для аудита */
    public $auditModels = [];
    /** @var array */
    private $oldAttributes = [];
    /** @var array */
    private $oldBatchAttributes = [];
    /** @var array */
    private $newBatchAttributes = [];

//    /**
//     * @return string|null
//     */
//    public static function getModuleLabel()
//    {
//        return Yii::t('yii2admin', 'Аудит');
//    }

    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        if (!$this->auditModels) { return; }

        foreach ($this->auditModels as $model) {
            $service = $this->getAuditService()->getModelService($model);
            $serviceClass = get_class($service);
            if (!$service) {
                continue;
            }

            Event::on($model, ActiveRecord::EVENT_AFTER_FIND, function ($event) use ($model) {
                $uniqueKey = $model . ':' . $this->getAuditService()->getPrimaryKey($event->sender);
                $this->oldAttributes[$uniqueKey] = $event->sender->getAttributes();
            });

            /*
             * Обработка batchInsert, подготавливает старые и новые атрибуты для аудита
             */
            Event::on($serviceClass, Service::EVENT_BEFORE_BATCH_INSERT, function ($event) use ($model, $service) {
                if (!$this->batchInsertAuditIsAllowed($event, $service)) {
                    return;
                }

                list(
                    $this->oldBatchAttributes,
                    $this->newBatchAttributes
                ) = $this->getAuditService()->prepareAttributesForBatchInsert($model, $event->rows, $event->fields);
            });
            /* ===================================================================================================== */

            /*
             * После того как данные сохранились в базу посредством batchInsert пишем в аудит
             */
            Event::on($serviceClass, Service::EVENT_AFTER_BATCH_INSERT, function ($event) use ($model, $service) {

                if (!$this->batchInsertAuditIsAllowed($event, $service)) {
                    return;
                }

                if (!$this->oldBatchAttributes || !$this->newBatchAttributes) {
                    return;
                }

                $this->getAuditService()->auditBatchInsert($model, $this->oldBatchAttributes, $this->newBatchAttributes);
            });
            /* ===================================================================================================== */

            /*
             * Обработка любого изменения модели
             */
            foreach ($this->getAuditService()->getEventsActionMap() as $eventName => $action) {
                Event::on($serviceClass, $eventName, function ($event) use ($model, $action) {
                    if (!$this->modelAuditIsAllowed($event)) {
                        return;
                    }

                    $uniqueKey = $model . ':' . $this->getAuditService()->getPrimaryKey($event->model);
                    $this->getAuditService()->auditModel($event->model, $action, $this->oldAttributes[$uniqueKey]);
                });
            }
        }
    }

    /**
     * @return AuditService
     */
    private function getAuditService()
    {
        return Yii::$app->auditService;
    }

    /**
     * Проверяет можно ли проводить аудит на текущей модели
     *
     * @param Event $event
     * @return bool
     */
    private function modelAuditIsAllowed($event)
    {
        if (!isset($event->model)) {
            return false;
        }

        if ($event->model instanceof Audit) {
            return false;
        }

        return true;
    }

    /**
     * Проверяет можно ли проводить аудит на текущей модели при batch insert`е
     *
     * @param Event $event
     * @param Service $service
     * @return bool
     */
    private function batchInsertAuditIsAllowed($event, $service)
    {
        $serviceClass = get_class($service);
        $auditServiceClass = get_class($this->getAuditService());

        if (!$event->sender instanceof $serviceClass || $event->sender instanceof $auditServiceClass) {
            return false;
        }

        if (!isset($event->fields) && !isset($event->rows)) {
            return false;
        }

        return true;
    }
}
