<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;


/**
 * This is the model class for table "ingredient".
 *
 * @property int                $id
 * @property int                $user_id
 * @property int|null           $category_id
 * @property string             $name
 * @property float              $protein
 * @property float              $fat
 * @property float              $carbohydrate
 * @property string|null        $note
 * @property string             $created_at
 * @property string|null        $updated_at
 *
 * @property Category           $category
 * @property RecipeIngredient[] $recipeIngredient
 * @property User               $user
 */
class Ingredient extends \yii\db\ActiveRecord
{
    public const MAX_NAME_LENGTH = 255;


    /**
     * {@inheritdoc}
     */
    public static function tableName() :string
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        // @formatter:off
        return [
            [['user_id', 'name', 'protein', 'fat', 'carbohydrate'], 'required'],
            [['user_id', 'category_id'], 'integer'],
            [['protein', 'fat', 'carbohydrate'], 'number'],
            [['note'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => self::MAX_NAME_LENGTH],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'id'           => Yii::t( 'common', 'ID' ),
            'user_id'      => Yii::t( 'common', 'User ID' ),
            'category_id'  => Yii::t( 'app', 'Category ID' ),
            'name'         => Yii::t( 'common', 'Name' ),
            'protein'      => Yii::t( 'common', 'Protein' ),
            'fat'          => Yii::t( 'common', 'Fat' ),
            'carbohydrate' => Yii::t( 'common', 'Carbohydrate' ),
            'note'         => Yii::t( 'common', 'Note' ),
            'created_at'   => Yii::t( 'common', 'Created At' ),
            'updated_at'   => Yii::t( 'common', 'Updated At' ),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory() :ActiveQuery
    {
        return $this->hasOne( Category::class, ['id' => 'category_id'] );
    }

    /**
     * Gets query for [[RecipeIngredients]].
     *
     * @return ActiveQuery|RecipeIngredientQuery
     */
    public function getRecipeIngredients() :ActiveQuery|RecipeIngredientQuery
    {
        return $this->hasMany( RecipeIngredient::class, ['ingredient_id' => 'id'] );
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser() :ActiveQuery
    {
        return $this->hasOne( User::class, ['id' => 'user_id'] );
    }

    /**
     * {@inheritdoc}
     * @return IngredientQuery the active query used by this AR class.
     */
    public static function find() :IngredientQuery
    {
        return new IngredientQuery( get_called_class() );
    }

    /**
     * Function to get the list of categories for dropdown with first element as empty
     *
     * @return array
     */
    public function getCategoryList() :array
    {
        $query = Category::find();
        $query->select( [
                            'name',
                            'id',
                        ] );
        $query->indexBy( 'id' );

        return [null => ''] + $query->column();
    }
}
