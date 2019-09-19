<?php
/**
 * Файл класса ActiveRecord
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\models;

use chulakov\model\models\mappers\MappingRecord;

/**
 * Базовый класс размечаемой модели
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord implements MappingRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return static::mapper()->modelRules();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return static::mapper()->modelLabels();
    }
}
