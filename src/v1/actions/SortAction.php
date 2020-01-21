<?php

namespace kamaelkz\yii2admin\v1\actions;

use Yii;
use concepture\yii2logic\actions\Action;
use yii\web\NotFoundHttpException;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;
use PDO;

/**
 * Сортровка drag and drop
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class SortAction extends Action
{
    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->controller->enableCsrfValidation = false;
        parent::init();
    }

    /**
     * Название дейстия
     *
     * @return string
     */
    public static function actionName()
    {
        return 'sort';
    }

    /**
     * @param string $sortColumn
     */
    public function run($sortColumn = 'sort')
    {
        $service = $this->getService();
        # todo: перенести в logic core с проверкой на mysql
        $connection = $service->getDb();
        $connection->createCommand('SET sql_mode=""')->execute();
        if(! $service) {
            throw new NotFoundHttpException('Service is not defined.');
        }

        $sort = Yii::$app->request->post('sort');
        if($sort && is_array($sort)) {
            try{
                $data = [];
                foreach ($sort as $position => $id) {
                    $data[] = [$id, $position + 1];
                }

                $service->batchInsert(['id', $sortColumn], $data);

                return $this->controller->responseNotify(FlashAlertEnum::SUCCESS);
            } catch (\Exception $e) {
                return $this->controller->responseNotify(FlashAlertEnum::WARNING, YII_DEBUG ? $e->getMessage() : null);
            }
        }
    }
}