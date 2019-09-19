<?php
/**
 * Файл класса AcceptedModelType
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\mappers\types;

/**
 * Интерфейс разрешенного типа модели
 */
interface AcceptedModelType
{
    /**
     * Валидация типа модели
     *
     * @param mixed $model
     * @return bool
     */
    public function isValid($model);

    /**
     * Преобразование типа в строку
     *
     * @return string
     */
    public function __toString();
}
