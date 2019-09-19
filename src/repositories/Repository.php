<?php
/**
 * Файл класса Repository
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\repositories;

use yii\db\Query;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\ExpressionInterface;
use chulakov\model\exceptions\NotFoundModelException;
use chulakov\model\exceptions\DeleteModelException;
use chulakov\model\exceptions\SaveModelException;

/**
 * Репозиторий
 */
abstract class Repository
{
    /**
     * Модель поиска
     * 
     * @return ActiveQuery|Query
     */
    abstract public function query();

    /**
     * Поиск модели
     *
     * @param integer|array $id
     * @return ActiveRecord
     * @throws NotFoundModelException
     */
    public function findOne($id)
    {
        if ($model = $this->find(['id' => $id])->one()) {
            return $model;
        }
        throw new NotFoundModelException();
    }

    /**
     * Поиск всех моделей по их ID
     *
     * @param array|integer $ids
     * @return ActiveRecord[]
     */
    public function findAll($ids = null)
    {
        $conditions = [];
        if (!is_null($ids)) {
            $conditions['id'] = $ids;
        }
        return $this->find($conditions)->all();
    }

    /**
     * Выборка по условию
     *
     * @param array|string|ExpressionInterface $conditions
     * @return ActiveQuery|Query
     */
    public function find($conditions)
    {
        return $this->query()->andWhere($conditions);
    }

    /**
     * Сохранение модели с проверкой успешности сохранения
     *
     * @param ActiveRecord $model
     * @return bool
     * @throws SaveModelException
     */
    public function save(ActiveRecord $model)
    {
        if (!$model->save(false)) {
            throw new SaveModelException();
        }
        return true;
    }

    /**
     * Удаление модели по ее id
     *
     * @param ActiveRecord $model
     * @return false|int
     * @throws DeleteModelException
     */
    public function delete($model)
    {
        $previous = null;
        try {
            return $model->delete();
        }
        catch (\Exception $e) { $previous = $e; }
        catch (\Throwable $e) { $previous = $e; }

        $message = $previous
            ? $previous->getMessage()
            : 'Не удалось удалить модель из базы данных.';
        throw new DeleteModelException(
            $message, 0, $previous
        );
    }
}
