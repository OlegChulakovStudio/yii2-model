<?php
/**
 * Файл класса FactoryInterface
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\factories;

use yii\base\Model;
use yii\db\ActiveRecord;
use chulakov\model\models\mappers\Mapper;
use chulakov\model\models\search\SearchForm;
use chulakov\model\exceptions\FormException;

/**
 * Интерфейс абстрактной фабрики окружения модели
 */
interface FactoryInterface
{
    /**
     * Создать модель
     *
     * @param array $config
     * @return ActiveRecord|Model
     */
    public function makeModel($config = []);

    /**
     * Создать поисковую модель
     *
     * @param array $config
     * @return SearchForm|Model
     */
    public function makeSearch($config = []);

    /**
     * Создать форму
     *
     * @param Mapper $mapper
     * @param ActiveRecord|Model $model
     * @param array $config
     * @return Model
     * @throws FormException
     */
    public function makeForm($mapper, $model = null, $config = []);
}
