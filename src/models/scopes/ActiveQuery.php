<?php
/**
 * Файл класса ActiveQuery
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\scopes;

use yii\db\ActiveRecord;
use yii\db\Connection;

/**
 * Базовый построитель запросов
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * @var bool Использовать ли лимит при выборке через one()
     */
    protected $useLimitInOne = true;

    /**
     * Получение единственной модели с добавление лимита в запрос.
     *
     * @param Connection|null $db
     * @return ActiveRecord
     */
    public function one($db = null)
    {
        if ($this->useLimitInOne) {
            $this->limit(1);
        }
        return parent::one($db);
    }
}
