<?php
/**
 * Файл класса NullType
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\mappers\types;

/**
 * Разрешение для отсутствия модели
 */
class NullType implements AcceptedModelType
{
    /**
     * Валидация типа модели
     *
     * @param mixed $model
     * @return bool
     */
    public function isValid($model)
    {
        return is_null($model);
    }

    /**
     * Преобразование типа в строку
     *
     * @return string
     */
    public function __toString()
    {
        return 'NULL';
    }
}
