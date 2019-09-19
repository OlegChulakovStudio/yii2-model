<?php
/**
 * Файл класса Service
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\services;

use yii\db\Query;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\base\Model;
use chulakov\model\repositories\Repository;
use chulakov\model\models\mappers\Mapper;
use chulakov\model\models\search\SearchForm;
use chulakov\model\models\factories\FactoryInterface;
use chulakov\model\exceptions\NotFoundModelException;
use chulakov\model\exceptions\DeleteModelException;
use chulakov\model\exceptions\SaveModelException;
use chulakov\model\exceptions\FormException;

/**
 * Сервис
 *
 * @mixin Repository
 * @method ActiveQuery|Query query() via [[Repository]]
 */
abstract class Service
{
    /**
     * @var Mapper
     */
    protected $mapper;
    /**
     * @var FactoryInterface
     */
    protected $factory;
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Создание модели формы
     *
     * @param ActiveRecord|null $model
     * @param array $config
     * @return Model
     * @throws FormException
     */
    public function form($model = null, $config = [])
    {
        return $this->factory->makeForm($this->mapper, $model, $config);
    }

    /**
     * Создание формы поиска моделей
     *
     * @param array $config
     * @return SearchForm|Model
     */
    public function search($config = [])
    {
        return $this->factory->makeSearch($config);
    }

    /**
     * Создание модели
     *
     * @param array $config
     * @return Model|ActiveRecord
     */
    public function model($config = [])
    {
        return $this->factory->makeModel($config);
    }

    /**
     * Создание нового объекта
     *
     * @param Model $form
     * @return Model
     * @throws \Exception
     */
    public function create($form)
    {
        $model = $this->model();
        if ($this->update($model, $form)) {
            return $model;
        }
        return null;
    }

    /**
     * Обновление информации в объекте
     *
     * @param ActiveRecord $model
     * @param Model $form
     * @return boolean
     * @throws \Exception
     */
    public function update($model, $form)
    {
        try {
            $this->fill($model, $form);
            if ($this->repository->save($model)) {
                return true;
            }
        } catch (SaveModelException $e) {
            $form->addErrors($model->getErrors());
            throw $e;
        }
        return false;
    }

    /**
     * Удаление объекта
     *
     * @param integer $id
     * @return false|integer
     * @throws DeleteModelException
     * @throws NotFoundModelException
     */
    public function delete($id)
    {
        return $this->repository->delete(
            $this->repository->findOne($id)
        );
    }

    /**
     * Заполнение модели из формы
     *
     * @param Model $model
     * @param Model $form
     */
    protected function fill($model, $form)
    {
        $model->setAttributes($form->getAttributes(
            $this->mapper->fillAttributes()
        ));
    }

    /**
     * @inheritdoc
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->repository, $name)) {
            return call_user_func_array([$this->repository, $name], $arguments);
        }
        throw new \BadMethodCallException();
    }
}
