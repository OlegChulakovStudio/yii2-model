<?php
/**
 * Файл класса ModelType
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\mappers\types;

use yii\base\InvalidArgumentException;

/**
 * Разрешение для модели в виде объекта конкретного класса
 */
class ModelType implements AcceptedModelType
{
    /**
     * @var string
     */
    protected $modelClass;

    /**
     * Конструктор типа модели
     *
     * @param string $modelClass
     */
    public function __construct($modelClass)
    {
        if (!class_exists($modelClass)) {
            throw new InvalidArgumentException("Класс {$modelClass} не существует.");
        }
        $this->modelClass = $modelClass;
    }

    /**
     * Валидация типа модели
     *
     * @param mixed $model
     * @return bool
     */
    public function isValid($model)
    {
        return $model instanceof $this->modelClass;
    }

    /**
     * Преобразование типа в строку
     *
     * @return string
     */
    public function __toString()
    {
        $parts = explode('\\', $this->modelClass);
        return array_pop($parts);
    }
}
