<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%recipe_ingredient}}".
 *
 * @property int         $id
 * @property int         $user_id
 * @property int         $recipe_id
 * @property int         $ingredient_id
 * @property float       $quantity
 * @property string      $created_at
 * @property string|null $updated_at
 *
 * @property Ingredient  $ingredient
 * @property Recipe      $recipe
 * @property User        $user
 */
class RecipeIngredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() :string
    {
        return '{{%recipe_ingredient}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        // @formatter:off
        return [
            [['user_id', 'recipe_id', 'ingredient_id', 'quantity'], 'required'],
            [['user_id', 'recipe_id', 'ingredient_id'], 'integer'],
            [['quantity'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['ingredient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredient::class, 'targetAttribute' => ['ingredient_id' => 'id']],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::class, 'targetAttribute' => ['recipe_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
        // @formatter:on
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() :array
    {
        return [
            'id'            => Yii::t( 'common', 'ID' ),
            'user_id'       => Yii::t( 'common', 'User ID' ),
            'recipe_id'     => Yii::t( 'common', 'Recipe ID' ),
            'ingredient_id' => Yii::t( 'common', 'Ingredient ID' ),
            'quantity'      => Yii::t( 'common', 'Quantity' ),
            'created_at'    => Yii::t( 'common', 'Created At' ),
            'updated_at'    => Yii::t( 'common', 'Updated At' ),
        ];
    }

    /**
     * Gets query for [[Ingredient]].
     *
     * @return ActiveQuery|IngredientQuery
     */
    public function getIngredient() :IngredientQuery|ActiveQuery
    {
        return $this->hasOne( Ingredient::class, ['id' => 'ingredient_id'] );
    }

    /**
     * Gets query for [[Recipe]].
     *
     * @return ActiveQuery|RecipeQuery
     */
    public function getRecipe() :ActiveQuery|RecipeQuery
    {
        return $this->hasOne( Recipe::class, ['id' => 'recipe_id'] );
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery|ActiveQuery
     */
    public function getUser() :ActiveQuery
    {
        return $this->hasOne( User::class, ['id' => 'user_id'] );
    }

    /**
     * {@inheritdoc}
     * @return RecipeIngredientQuery the active query used by this AR class.
     */
    public static function find() :RecipeIngredientQuery
    {
        return new RecipeIngredientQuery( get_called_class() );
    }
}
