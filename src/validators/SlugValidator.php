<?php
/**
 * Файл класса SlugValidator
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\validators;

use yii\validators\RegularExpressionValidator;

/**
 * Валидатор URL метки
 *
 * @package chulakov\model\validators
 */
class SlugValidator extends RegularExpressionValidator
{
    /**
     * @var string Паттерн валидации url метки
     */
    public $pattern = '/^[0-9-_a-z]+$/i';
}
