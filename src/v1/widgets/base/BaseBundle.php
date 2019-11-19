<?php

namespace kamaelkz\yii2admin\v1\widgets\base;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Базовый пакет ресурсов виджета
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
abstract class BaseBundle extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $class = static::class;
        $reflector = new \ReflectionClass($class);
        $namespace = "{$reflector->getNamespaceName()}\\resources";
        $namespace = str_replace('\\', '/', $namespace);
        $resourcesFolder = Yii::getAlias("@{$namespace}");
        if(
            ! is_dir($resourcesFolder)
            || ! file_exists($resourcesFolder)
        ) {
            return;
        }

        $this->sourcePath = $resourcesFolder;
    }

    public $jsOptions = [
        'position' => View::POS_END
    ];

    public $publishOptions = [
        'forceCopy'=> YII_DEBUG  ? true : false,
    ];
}