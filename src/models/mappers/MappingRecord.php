<?php
/**
 * Файл класса MappingRecord
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\mappers;

/**
 * Интерфейс требующий от Модели реализации метода мапинга.
 * В основном предназначен для абстрактных базовых моделей.
 */
interface MappingRecord
{
    /**
     * Получить информационный объект
     *
     * @return Mapper
     */
    public static function mapper();
}
