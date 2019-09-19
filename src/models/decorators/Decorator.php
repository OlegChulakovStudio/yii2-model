<?php
/**
 * Файл класса Decorator
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\decorators;

use yii\base\Model;
use yii\helpers\Inflector;

/**
 * Базовый декоратор, реализующий логику обращения к вложенной сущности.
 * Декоратор должен применяться в финальной стадии обработки объекта перед его выводом.
 */
abstract class Decorator
{
    /**
     * @var Model
     */
    protected $entity;
    /**
     * @var array Соотношение полей
     */
    protected $fields = [];

    /**
     * Декорирование модели
     *
     * @param Model $model
     * @param array $fields
     * @return Decorator
     */
    public static function decorate($model, $fields = [])
    {
        $decorator = new static($model);
        if ($fields) {
            $decorator->addConvertedFields($fields);
        }
        return $decorator;
    }

    /**
     * Конструктор сущности
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->entity = $model;
    }

    /**
     * Установка соотношения полей модели и декоратора
     *
     * @param array $fields
     */
    public function addConvertedFields($fields)
    {
        foreach ($fields as $name => $value) {
            $this->fields[$name] = $value;
        }
    }

    /**
     * Поиска декорирующей функции для свойства вложенной сущности
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->fields[$name])) {
            $name = $this->fields[$name];
        }
        $methodName = 'get' . Inflector::camelize($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
        return $this->entity->{$name};
    }

    /**
     * Назвачение декорирующего поля для свойства вложенной сущности
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (isset($this->fields[$name])) {
            $name = $this->fields[$name];
        }
        $this->entity->{$name} = $value;
    }

    /**
     * Перенаправления вызова метода на вложенную сущность
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->entity->$name($arguments);
    }
}
