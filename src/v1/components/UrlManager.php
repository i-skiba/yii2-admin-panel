<?php

namespace kamaelkz\yii2admin\v1\components;

use Yii;
use yii\web\UrlManager as Base;
use concepture\yii2handbook\traits\ServicesTrait as HandbookServiceTrait;

/**
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
class UrlManager extends Base
{
    use HandbookServiceTrait;

    /**
     * @var integer
     */
    private $domainId;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->domainId = Yii::$app->getRequest()->get('domain_id');

        if($this->domainId) {
            $this->domainService()->setVirtualDomainId($this->domainId);
        }

        return parent::init();
    }
    /**
     * @inheritDoc
     */
    public function createUrl($params)
    {
        if(! isset($params['domain_id']) && $this->domainId) {
            $params['domain_id'] = $this->domainId;
        }

        return parent::createUrl($params);
    }
}