<?php
/**
 * Файт класса RelationService
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace chulakov\model\services;

use yii\base\Model;
use yii\db\ActiveRecord;
use chulakov\model\exceptions\SaveModelException;

/**
 * Сервис с наличием связанных данных
 */
abstract class RelationService extends Service
{
    use RelationAssignationTrait;

    /**
     * Обновление модели со всеми ее связями в транзакции
     *
     * @param ActiveRecord $model
     * @param Model $form
     * @return bool
     * @throws \Exception
     */
    public function update($model, $form)
    {
        $transaction = $model::getDb()->beginTransaction();
        try {
            $this->fill($model, $form);
            if ($this->repository->save($model)) {
                $this->fillRelations($model, $form);
                $transaction->commit();
                return true;
            }
        } catch (\Exception $e) {
            if ($e instanceof SaveModelException) {
                $form->addErrors($model->getErrors());
            }
            $transaction->rollBack();
            throw $e;
        }
        return false;
    }

    /**
     * Сохранение реляций модели
     *
     * @param ActiveRecord $model
     * @param Model $form
     */
    abstract protected function fillRelations($model, $form);
}
