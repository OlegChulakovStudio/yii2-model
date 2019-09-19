<?php
/**
 * Файл трейта QueryActiveTrait
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\scopes;

/**
 * Примесь запроса активности
 *
 * @mixin \yii\db\ActiveQuery
 */
trait QueryActiveTrait
{
    /**
     * Фильтрация активных записей
     *
     * @param bool $is
     * @return static
     */
    public function activeOnly($is = true)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[is_active]]' => (int)$is]);
    }
}
