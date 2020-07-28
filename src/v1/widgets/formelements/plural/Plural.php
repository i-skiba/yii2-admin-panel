<?php
namespace kamaelkz\yii2admin\v1\widgets\formelements\plural;

use yii\base\Model;
use yii\base\Widget;
use yii\base\Exception;
use yii\widgets\ActiveForm;
use yii\base\InvalidConfigException;
use concepture\yii2handbook\enum\DeclinationFormatEnum;

/**
 * Class Plural
 *
 * @package kamaelkz\yii2admin\v1\widgets\formelements\plural
 * @author Poletaev Eugene <evgstn7@gmail.com>
 */
class Plural extends Widget
{
    /**
     * @var string
     */
    public $view = 'view';
    /**
     * @var Model
     */
    public $model;
    /**
     * @var ActiveForm
     */
    public $form;
    /**
     * @var string Оригнал перевода
     */
    public $originText;
    /**
     * @var string Атрибут содержащий склонения
     */
    public $pluralAttr;
    /**
     * @var string Атрибут куда будет сохраняться перевод
     */
    public $targetAttr;
    /**
     * @var string токен для подстановки
     */
    public $token = '{plural}';
    /**
     * @var integer формат склонения
     */
    public $declination_format = DeclinationFormatEnum::FULL;

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->form) || !$this->form instanceof ActiveForm) {
            throw new InvalidConfigException("The 'form' property must be set and must extend from '\\yii\\base\\Model'.");
        }

        if (empty($this->form) || !$this->model instanceof \yii\base\Model) {
            throw new InvalidConfigException("The 'model' property must be set and must extend from '\\yii\\widgets\\ActiveForm'.");
        }

        if (empty($this->originText)) {
            throw new InvalidConfigException("The 'originText' property must be set");
        }

        if (empty($this->pluralAttr)) {
            throw new InvalidConfigException("The 'pluralAttr' property must be set");
        }

        if (empty($this->targetAttr)) {
            throw new InvalidConfigException("The 'targetAttr' property must be set");
        }

        if (empty($this->token)) {
            throw new InvalidConfigException("The 'token' property must be set");
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function run()
    {
        return $this->render($this->view, [
            'form' => $this->form,
            'model' => $this->model,
            'targetAttr' => $this->targetAttr,
            'pluralAttr' => $this->pluralAttr,
            'origin' => $this->originText,
            'token' => $this->token,
            'declination_format' => $this->declination_format
        ]);
    }
}