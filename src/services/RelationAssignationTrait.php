<?php
/**
 * Файл трейта RelationAssignationTrait
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\services;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

trait RelationAssignationTrait
{
    /**
     * Сохранение связанных моделей
     *
     * @param ActiveRecord $model
     * @param integer|array $params
     * @param string $relations
     * @param string|ActiveRecord $class
     * @param array $extra
     * @return bool
     */
    protected function saveRelations($model, $params, $relations, $class = null, $extra = [])
    {
        if (is_null($class)) {
            $class = get_class($model);
        }

        $primaryKey = $class::primaryKey();
        if (count($primaryKey) > 1 || !isset($primaryKey[0])) {
            throw new \InvalidArgumentException('Не поддерживается обработка с составным primary key.');
        }
        $primaryKey = $primaryKey[0];

        $sorted = [];
        if ($models = ArrayHelper::index($class::findAll($params), $primaryKey)) {
            foreach ((array)$params as $id) {
                if (!empty($models[$id])) {
                    $sorted[] = $models[$id];
                }
            }
        }

        $this->reloadRelations($model, $sorted, $relations, $extra);
        return true;
    }

    /**
     * Связка дополнительных объектов
     *
     * @param ActiveRecord $model
     * @param ActiveRecord[] $targetModels
     * @param string $relationName
     * @param array $extra
     */
    protected function reloadRelations($model, $targetModels, $relationName, $extra = [])
    {
        $model->unlinkAll($relationName, true);
        foreach ($targetModels as $targetModel) {
            $model->link($relationName, $targetModel, $extra);
        }
    }
}
