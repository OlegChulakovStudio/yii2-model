<?php
/**
 * Файл класса ListFormatter
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\formatters;

use yii\web\Request;

/**
 * Интерфейс форматтера списка моделей
 */
interface ListFormatter
{
    /**
     * Форматирование ответа для списка
     *
     * @param Request $request
     * @return array
     */
    public function asList(Request $request);
}
