<?php

namespace kamaelkz\yii2admin\v1\actions;

use Yii;
use concepture\yii2logic\actions\Action;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;
use kamaelkz\yii2admin\v1\enum\FlashAlertEnum;

/**
 * Редактрирование одной колонки
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class EditableColumnAction extends Action
{
    /**
     * Название дейстия
     *
     * @return string
     */
    public static function actionName()
    {
        return 'editable-column';
    }

    /**
     * @inheritDoc
     */
    public function run($column, $pk, $type, $required)
    {
        $service = $this->getService();
        if(! $service) {
            throw new NotFoundHttpException('Service is not defined.');
        }

        $model = $service->getOneByCondition(['id' => $pk]);
        $class = get_class($model);
        if(! isset($model->{$column})) {
            throw new NotFoundHttpException("Column `{$column}` in class {$class} not found.");
        }

        if($model->{$column} == $model->getPrimaryKey()) {
            throw new NotFoundHttpException("Unable to edit primary key.");
        }

        $form = new DynamicModel([$column]);
        $form->{$column} = $model->{$column};
        $form->addRule(
            [$column],
            $required ? 'required' : 'string',
            [
                'message' => Yii::t('yii2admin', 'Необходимо запонить поле')
            ]
        );
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $service->updateColumn($model, $column, $form->{$column});

            return $this->controller->responseNotify(FlashAlertEnum::SUCCESS);
        }

        return $this->render('@yii2admin/themes/views/general/update_column', [
            'model' => $form,
            'column' => $column,
            'originModel' => $model,
            'type' => $type
        ]);
    }
}