<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Category]].
 *
 * @see Category
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Category[]|array
     */
    public function all($db = null) :array
    {
        return parent::all( $db );
    }

    /**
     * {@inheritdoc}
     * @return Category|array|null
     */
    public function one($db = null) :array|Category|null
    {
        return parent::one( $db );
    }

    /**
     * Filter by user ID
     *
     * @param int $userId
     *
     * @return CategoryQuery
     */
    public function userId(int $userId) :CategoryQuery
    {
        return $this->andWhere( ['user_id' => $userId] );
    }
}
