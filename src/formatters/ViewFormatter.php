<?php
/**
 * Файл класса ViewFormatter
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\formatters;

/**
 * Интерфейс форматтера модели
 */
interface ViewFormatter
{
    /**
     * Форматирование ответа для единичной модели
     *
     * @param string|integer $key
     * @return array
     */
    public function asView($key);
}
