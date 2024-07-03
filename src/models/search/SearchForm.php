<?php
/**
 * Файл класса SearchForm
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\search;

use yii\base\Model;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;

/**
 * Поисковая форма для WEB приложения.
 * Предоставляет интерфейс для быстрого построения поиска.
 */
abstract class SearchForm extends Model
{
    /**
     * Осуществление поиска в базе данных запрошенных моделей и выдача провайдера данных
     *
     * @param array $params
     * @param string|null $formName
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        // Получение данных для фильтров
        $this->load($params, $formName);

        // Провайдер и запрос
        $query = $this->buildQuery();
        $provider = $this->buildProvider($query);

        // Валидация полученных данных
        if (!$this->validate()) {
            return $provider;
        }

        // Применение фильтров к модели поиска
        $this->applyFilter($query);

        // Итоговый фильтр
        return $provider;
    }

    /**
     * Применение фильтров к условию выборки
     *
     * @param ActiveQuery $query
     */
    protected function applyFilter(ActiveQuery $query)
    {
        // Заглушка. Не всегда требуется поиск по условиям, порой достаточно простой выборки
    }

    /**
     * Сборка провайдера данных
     *
     * @param ActiveQuery $query
     * @return ActiveDataProvider
     */
    protected function buildProvider($query)
    {
        return new ActiveDataProvider([
            'pagination' => $this->buildPagination(),
            'sort' => $this->buildSort(),
            'query' => $query,
        ]);
    }

    /**
     * Сборка массива пагинации
     *
     * @return array|boolean
     */
    protected function buildPagination()
    {
        return false;
    }

    /**
     * Сборка массива данных для сортировки.
     * Сортировка по умолчанию подготавливается как пустой массив.
     *
     * Пример заполнения массива сортировки:
     *
     * ```php
     * return [
     *      'defaultOrder' => [
     *          'id' => SORT_ASC
     *      ],
     *      'attributes' => ['id']
     * ];
     * ```
     *
     * @return array
     */
    protected function buildSort()
    {
        return [];
    }

    /**
     * Сборка класса условий выборки из базы данных
     *
     * @return ActiveQuery
     */
    abstract protected function buildQuery();
}
