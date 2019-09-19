<?php
/**
 * Файл класса Select2RelationInterface
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\forms;

use chulakov\model\forms\entities\RelationDataInterface;

interface RelationOwnerInterface
{
    /**
     * Инициализация данных для организации реляций
     *
     * @return RelationDataInterface[]
     */
    public function initRelationData();
}
