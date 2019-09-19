<?php
/**
 * Файл класса RelationData
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\forms\entities;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class RelationData implements RelationDataInterface
{
    /**
     * @var ActiveRecord|string
     */
    protected $relationClass;
    /**
     * @var string
     */
    protected $relationName;
    /**
     * @var ActiveRecord|null
     */
    protected $model;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $key;

    /**
     * Создания простого объекта реляции без завязки на модель
     *
     * @param string $relationClass
     * @param string $name
     * @param string $key
     * @return RelationData
     */
    public static function createSimple($relationClass, $name = 'title', $key = 'id')
    {
        return new static($relationClass, null, '', $name, $key);
    }

    /**
     * Констуктор данных для организации реляции
     *
     * @param string $relationClass
     * @param string $relationName
     * @param ActiveRecord|null $model
     * @param string $name
     * @param string $key
     */
    public function __construct($relationClass, $model = null, $relationName = '', $name = 'title', $key = 'id')
    {
        $this->relationClass = $relationClass;
        $this->relationName = $relationName;
        $this->model = $model;
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * Получение данных для списка релиции
     *
     * @param integer|string|array $ids
     * @return array
     */
    public function getData($ids)
    {
        $models = [];
        if ($this->model) {
            $models = $this->loadFromModelRelation();
        }
        $ids = (array)$ids;
        if ($need = array_diff($ids, array_keys($models))) {
            $models = $models + $this->loadFromRelation($need);
            if (count($models) > 1) {
                $models = array_replace(array_flip($ids), $models);
            }
        }
        return $models;
    }

    /**
     * Загрузка моделей из реляции модели
     *
     * @return array
     */
    protected function loadFromModelRelation()
    {
        $models = $this->model->{$this->relationName};
        if (!is_array($models)) {
            $models = array_filter([$models]);
        }
        return ArrayHelper::map(
            $models, $this->key, $this->name
        );
    }

    /**
     * Загрузка данных из реляции
     *
     * @param integer|string|array $id
     * @return array
     */
    protected function loadFromRelation($id)
    {
        $modelClass = $this->relationClass;
        return ArrayHelper::map(
            $modelClass::find()
                ->andWhere([$this->key => $id])
                ->select([$this->key, $this->name])
                ->asArray()
                ->all(),
            $this->key, $this->name
        );
    }
}
