<?php
/**
 * Файл класса ClearMultibyteValidator
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\validators;

use yii\base\Model;
use yii\validators\Validator;
use sem\helpers\string\MultibyteStringHelper;

/**
 * Очистка мультибайтовых символов из строки.
 */
class ClearMultibyteValidator extends Validator
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
     * @var Validator[] Список инициализированных валидаторов
     */
    protected $_validators = [];

    /**
     * Создание валидаторов
     *
     * @return Validator[]
     */
    protected function createValidators()
    {
        $model = new Model();
        return [
            static::createValidator('filter', $model, $this->attributes, [
                'skipOnArray' => $this->skipOnArray,
                'filter' => 'trim',
            ]),
            static::createValidator('filter', $model, $this->attributes, [
                'skipOnArray' => $this->skipOnArray,
                'filter' => function ($value) {
                    return MultibyteStringHelper::rmExtendedSymbols($value);
                },
            ]),
        ];
    }

    /**
     * Получение готовых валидаторов
     *
     * @return Validator[]
     */
    protected function getValidators()
    {
        if (empty($this->_validators)) {
            $this->_validators = $this->createValidators();
        }
        return $this->_validators;
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        foreach ($this->getValidators() as $validator) {
            $validator->validateAttribute($model, $attribute);
        }
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $validations = [];
        foreach ($this->getValidators() as $validator) {
            $validations[] = $validator->clientValidateAttribute($model, $attribute, $view);
        }
        return implode(' ', $validations);
    }
}
