<?php

use concepture\yii2logic\console\migrations\Migration;
use concepture\yii2logic\enum\StatusEnum;
use kamaelkz\yii2admin\v1\modules\uikit\forms\UikitForm;
use kamaelkz\yii2admin\v1\modules\hints\forms\AdminHintsForm;
use kamaelkz\yii2admin\v1\modules\hints\enum\AdminHintsTypeEnum;

/**
 * Идентификатор домена
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class m200331_082605_yii2_admin_hints_records extends Migration
{
    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'yii2_admin_hints';
    }

    /**
     * @return \concepture\yii2handbook\services\LocaleService
     */
    private function getLocaleService()
    {
        return Yii::$app->localeService;
    }

    /**
     * @return \kamaelkz\yii2admin\v1\modules\hints\services\AdminHintsService
     */
    private function getHintsService()
    {
        return Yii::$app->adminHintsService;
    }

    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $form = new UikitForm();
        $formName = $form->underscoreFormName();

        $form = new AdminHintsForm();
        $form->name = "{$formName}_section_hints";
        $form->caption = 'Интерфейс. Cекция подсказок';
        $form->value = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum';
        $form->locale = $this->getLocaleService()->getCurrentLocaleId();
        $form->status = StatusEnum::ACTIVE;
        $this->getHintsService()->create($form);

        $form = new AdminHintsForm();
        $form->name = "{$formName}_hint_input";
        $form->caption = 'Интерфейс. Автоматическая подсказка для элемента формы';
        $form->value = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum';
        $form->locale = $this->getLocaleService()->getCurrentLocaleId();
        $form->status = StatusEnum::ACTIVE;
        $this->getHintsService()->create($form);

        $form = new AdminHintsForm();
        $form->name = "{$formName}_info_hint";
        $form->caption = 'Интерфейс. Иноформативная подсказка';
        $form->value = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum';
        $form->type = AdminHintsTypeEnum::INFO;
        $form->locale = $this->getLocaleService()->getCurrentLocaleId();
        $form->status = StatusEnum::ACTIVE;
        $this->getHintsService()->create($form);
    }
}
