<?php
/**
 * Файл класса ArrayType
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\mappers\types;

/**
 * Разрешение для модели в виде массива
 */
class ArrayType implements AcceptedModelType
{
    /**
     * Валидация типа модели
     *
     * @param mixed $model
     * @return bool
     */
    public function isValid($model)
    {
        return is_array($model);
    }

    /**
     * Преобразование типа в строку
     *
     * @return string
     */
    public function __toString()
    {
        return 'Array';
    }
}
