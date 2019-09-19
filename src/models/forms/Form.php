<?php
/**
 * Файл класса Form
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\forms;

use yii\base\Model;
use yii\db\ActiveRecord;
use chulakov\model\models\mappers\Mapper;
use chulakov\model\exceptions\AcceptedModelTypeException;
use chulakov\model\exceptions\FormException;

/**
 * Базовая форма обработки входящих данных
 *
 * @property integer $id
 */
abstract class Form extends Model
{
    /**
     * @var Mapper
     */
    protected $mapper;
    /**
     * @var ActiveRecord
     */
    protected $model;

    /**
     * Конструктор формы
     *
     * @param Mapper $mapper
     * @param ActiveRecord|null $model
     * @param array $config
     * @throws FormException
     */
    public function __construct(Mapper $mapper, $model = null, array $config = [])
    {
        $this->setMapper($mapper);
        $this->setModel($model);
        parent::__construct($config);
    }

    /**
     * Инициализация формы и заполнение ее данными из модели
     */
    public function init()
    {
        if ($this->hasModel()) {
            $this->setAttributes($this->model->getAttributes(
                $this->mapper->fillAttributes()
            ));
            $this->loadDependency();
        }
        $this->loadDefault();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->mapper->formLabels();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return $this->mapper->formRules();
    }

    /**
     * Получение идентификатора модели
     *
     * @return integer|array
     */
    public function getId()
    {
        if ($this->hasModel()) {
            $primaryKey = $this->model->getPrimaryKey(true);
            if (count($primaryKey) > 1) {
                return $primaryKey;
            }
            return array_shift($primaryKey);
        }
        return 0;
    }

    /**
     * Проверка наличия модели
     *
     * @return bool
     */
    public function hasModel()
    {
        return !is_null($this->model);
    }

    /**
     * Установка модели для отображения данных в форме
     *
     * @param ActiveRecord|null $model
     * @return bool
     * @throws AcceptedModelTypeException
     */
    protected function setModel($model = null)
    {
        $types = $this->mapper->acceptedModelTypes();
        foreach ($types as $type) {
            if ($type->isValid($model)) {
                $this->model = $model;
                return true;
            }
        }
        throw new AcceptedModelTypeException(
            'Недопустимый тип модели. Допустимые типы: [' . implode(', ', $types) . ']'
        );
    }

    /**
     * Установка и конфигурация на основе маппера
     *
     * @param Mapper $mapper
     */
    protected function setMapper(Mapper $mapper)
    {
        $this->mapper = $mapper;
        $this->mapper->setForm($this);
    }

    /**
     * Подгрузка данных из зависимостей
     */
    protected function loadDependency() {}

    /**
     * Подгрузка данных по умолчанию
     */
    protected function loadDefault() {}
}
