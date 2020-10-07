<?php
/**
 * Файл класса CleanXSSValidator
 *
 * @copyright Copyright (c) 2020, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\validators;

use yii\base\Model;
use voku\helper\AntiXSS;
use yii\validators\Validator;

class CleanXSSValidator extends Validator
{
    /**
     * @var bool
     */
    public $skipOnArray = true;
    /**
     * @var bool
     */
    public $skipOnEmpty = true;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * Создание валидаторов
     *
     * @return Validator
     */
    protected function createValidators()
    {
        return static::createValidator('filter', (new Model()), $this->attributes, [
            'skipOnArray' => $this->skipOnArray,
            'filter' => function ($value) {
                return (new AntiXSS())->xss_clean($value);
            },
        ]);
    }

    /**
     * Получения валидатора
     *
     * @return Validator
     */
    protected function getValidator()
    {
        if (empty($this->validator)) {
            $this->validator = $this->createValidators();
        }
        return $this->validator;
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $this->getValidator()->validateAttribute($model, $attribute);
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        return $this->getValidator()->clientValidateAttribute($model, $attribute, $view);
    }
}
