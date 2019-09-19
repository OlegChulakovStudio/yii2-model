<?php
/**
 * Файл класса QueryIdTrait
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\scopes;

/**
 * Примесь поиска по ID
 *
 * @mixin \yii\db\ActiveQuery
 */
trait QueryIdTrait
{
    /**
     * Поиск по ID
     *
     * @param integer|array $id
     * @return static
     */
    public function byId($id)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[id]]' => $id]);
    }
}
