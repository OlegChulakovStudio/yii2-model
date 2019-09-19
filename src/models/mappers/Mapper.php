<?php
/**
 * Файл класса Mapper
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\mappers;

use yii\base\Model;
use chulakov\model\models\mappers\types\AcceptedModelType;

/**
 * Абстрактный маппер модели
 *
 * @method array modelRules()
 * @method array formRules()
 * @method array modelLabels()
 * @method array formLabels()
 * @method array fillAttributes()
 * @method AcceptedModelType[] acceptedModelTypes()
 */
abstract class Mapper
{
    /**
     * @var Model
     */
    protected $form;
    /**
     * Проинициализированные данные
     *
     * @var array
     */
    protected $data = [];

    /**
     * Установка модели формы для расширение возможностей маппера
     *
     * @param $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     * Инициализация допустимых типов модели
     *
     * @return AcceptedModelType[]
     */
    abstract public function initAcceptedModelTypes();

    /**
     * Формирование массива заполняемых аттрибутов
     *
     * @return array
     */
    abstract public function initFillAttributes();

    /**
     * Формирование правил валидации модели
     *
     * @return array
     */
    abstract public function initModelRules();

    /**
     * Формирование массива названий атрибутов модели
     *
     * @return array
     */
    abstract public function initModelLabels();

    /**
     * Формирование правил валидации формы
     *
     * @return array
     */
    public function initFormRules()
    {
        return $this->modelRules();
    }

    /**
     * Получить метки атрибутов для формы
     *
     * @return array
     */
    public function initFormLabels()
    {
        $labels = $this->modelLabels();
        if ($attributes = $this->fillAttributes()) {
            $labels = array_intersect_key(
                $labels, array_combine($attributes, $attributes)
            );
        }
        return $labels;
    }

    /**
     * Вызов init функции с последующим кешированием
     *
     * @param string $name
     * @param array $arguments
     * @return array
     * @throws \BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        $method = 'init' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->data[$name] = call_user_func_array(
                [$this, $method], $arguments
            );
        }
        throw new \BadMethodCallException("Method {$name} does not exist.");
    }
}
