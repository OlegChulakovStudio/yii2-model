<?php
/**
 * Файл трейта QuerySlugTrait
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\scopes;

/**
 * Примесь запроса поиска по URL метке
 *
 * @mixin \yii\db\ActiveQuery
 */
trait QuerySlugTrait
{
    /**
     * Фильтрация записей по URL метке
     *
     * @param string $slug
     * @return static
     */
    public function bySlug($slug)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[slug]]' => $slug]);
    }
}
