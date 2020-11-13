<?php

namespace kamaelkz\yii2admin\v2\forms\collection;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\validators\Validator;
use kamaelkz\yii2admin\v1\validators\CollectionModelsValidator;

/**
 * Трейт для форм с коллекциями
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
trait CollectionAwareFormTrait
{
    /**
     * @return array
     */
    public function collectionForms()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function customizeForm(ActiveRecord $model = null)
    {
        if(
            ! $this instanceof CollectionAwareFormInterface
            || ! $this->collectionForms()
        ) {
            return parent::customizeForm($model);
        }

        $collectionForms = $this->collectionForms();
        foreach ($collectionForms as $attribute => $className) {
            if($this->{$attribute}) {
                continue;
            }

            $instance = Yii::createObject($className);
            if(! $instance instanceof CollectionItemFormInterface) {
                throw new InvalidConfigException('Collection item must be instance of `CollectionItemFormInterface`');
            }

            $instance->isNewRecord = true;
            $this->{$attribute}[] = $instance;
        }
    }

    /**
     * @inheritDoc
     */
    public function load($data, $formName = null)
    {
        $parent = parent::load($data, $formName);
        if(
            ! $this instanceof CollectionAwareFormInterface
            || ! $this->collectionForms()
            || ! Yii::$app->getRequest()->getIsPost()
        ) {
            return $parent;
        }

        $collectionForms = $this->collectionForms();
        foreach ($collectionForms as $attribute => $className) {
            $instance = Yii::createObject($className);
            $post = Yii::$app->getRequest()->post($instance->formName(), []);
            if(! $post) {
                $instance = Yii::createObject($className);
                if(! $instance instanceof CollectionItemFormInterface) {
                    throw new InvalidConfigException('Collection item must be instance of `CollectionItemFormInterface`');
                }

                $instance->isNewRecord = true;
                $this->{$attribute} = [$instance];
                continue;
            }

            $this->loadCollections($className, $attribute, $post , '');
            $validator = Validator::createValidator(
                CollectionModelsValidator::class,
                $this,
                $attribute,
                [
                    'modelClass' => $className
                ]
            );
            $this->getValidators()->append($validator);
        }

        return $parent;
    }

    /**
     * Заполнение атрибутов коллекции
     *
     * @param string $className
     * @param string $attribute
     * @param array $post
     * @throws \yii\base\InvalidConfigException
     */
    public function loadCollections(string $className, string $attribute, array $items)
    {
        $values = [];
        if($items) {
            foreach ($items as $item) {
                $instance = Yii::createObject($className);
                $instance->load($item, '');
                if(! $instance instanceof CollectionItemFormInterface) {
                    throw new InvalidConfigException('Collection item must be instance of `CollectionItemFormInterface`');
                }

                $instance->isNewRecord = false;
                $values[] = $instance;
            }
        }

        $this->{$attribute} = $values;
    }
}