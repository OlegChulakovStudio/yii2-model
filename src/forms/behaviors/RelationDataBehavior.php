<?php
/**
 * Файл класса RelationDataBehavior
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\forms\behaviors;

use yii\base\Behavior;
use chulakov\model\forms\RelationOwnerInterface;
use chulakov\model\forms\entities\RelationDataInterface;

class RelationDataBehavior extends Behavior
{
    /**
     * @var RelationOwnerInterface
     */
    public $owner;
    /**
     * @var RelationDataInterface[]
     */
    protected $relations = [];
    /**
     * @var array
     */
    protected $dataCache = [];

    /**
     * Получение данных реляции для Select2
     *
     * @param string $name
     * @param integer|string|array $ids
     * @return array
     */
    public function getRelationData($name, $ids)
    {
        if (isset($this->dataCache[$name])) {
            $this->checkCache($name, $ids);
        } else {
            $this->initRelationCache($name, $ids);
        }
        return $this->dataCache[$name];
    }

    /**
     * Перепроверка кеша данных и переинициализация
     *
     * @param string $name
     * @param integer|string|array $ids
     */
    protected function checkCache($name, $ids)
    {
        if (array_diff(array_keys($this->dataCache[$name]), (array)$ids)) {
            $this->initRelationCache($name, $ids);
        }
    }

    /**
     * Инициализация кеша данных реляции
     *
     * @param string $name
     * @param integer|string|array $ids
     */
    protected function initRelationCache($name, $ids)
    {
        if (empty($this->relations)) {
            $this->relations = $this->owner->initRelationData();
        }
        $this->dataCache[$name] = $this->relations[$name]->getData($ids);
    }
}
