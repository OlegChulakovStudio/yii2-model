<?php
/**
 * Файл класса RelationDataInterface
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\forms\entities;

interface RelationDataInterface
{
    /**
     * Получение данных для вывода в реляции
     *
     * @param integer|string|array $ids
     * @return array
     */
    public function getData($ids);
}
