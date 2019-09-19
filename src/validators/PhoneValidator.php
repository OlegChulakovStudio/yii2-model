<?php
/**
 * Файл класса PhoneValidator
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\validators;

use yii\validators\Validator;

/**
 * Класс валидатор мобильного телефона
 */
class PhoneValidator extends Validator
{
    /**
     * @var string Кодировка
     */
    public $encoding;
    /**
     * @var array|\Closure
     */
    public $filter;
    /**
     * @var integer Минимальная длина
     */
    public $min = 0;
    /**
     * @var integer Максимальная длина
     */
    public $max = 0;
    /**
     * @var array|int
     */
    public $length;
    /**
     * @var string Сообщение если длина телефона больше
     */
    public $tooLong;
    /**
     * @var string Сообщение если длина телефона меньше
     */
    public $tooShort;
    /**
     * @var string Сообщение о не эквивалентной длине телефона
     */
    public $notEqual;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (is_array($this->length)) {
            if (isset($this->length[0])) {
                $this->min = $this->length[0];
            }
            if (isset($this->length[1])) {
                $this->max = $this->length[1];
            }
            $this->length = null;
        }
        if ($this->encoding === null) {
            $this->encoding = \Yii::$app ? \Yii::$app->charset : 'UTF-8';
        }
        if ($this->message === null) {
            $this->message = \Yii::t('yii', '{attribute} is invalid.');
        }
        if ($this->min !== null && $this->tooShort === null) {
            $this->tooShort = \Yii::t('yii', '{attribute} should contain at least {min, number} {min, plural, one{character} other{characters}}.');
        }
        if ($this->max !== null && $this->tooLong === null) {
            $this->tooLong = \Yii::t('yii', '{attribute} should contain at most {max, number} {max, plural, one{character} other{characters}}.');
        }
        if ($this->length !== null && $this->notEqual === null) {
            $this->notEqual = \Yii::t('yii', '{attribute} should contain {length, number} {length, plural, one{character} other{characters}}.');
        }
        if (!is_callable($this->filter)) {
            $this->filter = function ($value) {
                return preg_replace('/[^0-9]+/', '', $value);
            };
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = call_user_func($this->filter, $model->{$attribute});

        if (empty($value)) {
            $this->addError($model, $attribute, $this->message);
            return;
        }

        $length = mb_strlen($value, $this->encoding);
        if ($this->min !== null && $length < $this->min) {
            $this->addError($model, $attribute, $this->tooShort, ['min' => $this->min]);
        }
        if ($this->max !== null && $length > $this->max) {
            $this->addError($model, $attribute, $this->tooLong, ['max' => $this->max]);
        }
        if ($this->length !== null && $length !== $this->length) {
            $this->addError($model, $attribute, $this->notEqual, ['length' => $this->length]);
        }

        $model->{$attribute} = $value;
    }
}
