<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Ingredient]].
 *
 * @see Ingredient
 */
class IngredientQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Ingredient[]|array
     */
    public function all($db = null) :array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Ingredient|array|null
     */
    public function one($db = null) :array|Ingredient|null
    {
        return parent::one($db);
    }

    /**
     * Filter by user_id
     *
     * @param int $userId
     *
     * @return IngredientQuery
     */
    public function userId(int $userId) :IngredientQuery
    {
        return $this->andWhere([Ingredient::tableName() . '.user_id' => $userId]);
    }
}
