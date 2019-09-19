<?php
/**
 * Файл трейта QuerySortTrait
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\scopes;

/**
 * Примесь добавления сортировку по полю sort
 *
 * @mixin \yii\db\ActiveQuery
 */
trait QuerySortTrait
{
    /**
     * Сортировка для выборки
     *
     * @param int $sort
     * @return static
     */
    public function sort($sort = SORT_ASC)
    {
        return $this->orderBy([$this->getPrimaryTableName() . '.[[sort]]' => $sort]);
    }
}
