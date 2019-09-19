<?php
/**
 * Файл класса Enum
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models\enums;

/**
 * Базовый класс справочного перечисления
 */
class Enum
{
    /**
     * @var array Расшифровка справочника
     */
    public static $labels = [];

    /**
     * @var string Дефолтное именование справочника
     */
    public static $defaultLabel = '(not set)';

    /**
     * @var string Категория переводов
     */
    protected static $translateCategory;

    /**
     * Получение расшифровки из справочника
     *
     * @param string $type
     * @return string
     */
    public static function getLabel($type)
    {
        $label = isset(static::$labels[$type])
            ? static::$labels[$type]
            : static::$defaultLabel;
        if (!empty(static::$translateCategory)) {
            $label = \Yii::t(self::$translateCategory, $label);
        }
        return $label;
    }

    /**
     * Разрешенные справочные значения для быстрой валидации
     *
     * @return array
     */
    public static function getRange()
    {
        return array_keys(static::$labels);
    }
}
