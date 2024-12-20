<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%recipe}}".
 *
 * @property int                $id
 * @property int                $user_id
 * @property string             $name
 * @property string|null        $description
 * @property string|null        $note
 * @property string             $created_at
 * @property string|null        $updated_at
 *
 * @property RecipeIngredient[] $recipeIngredients
 * @property User               $user
 */
class Recipe extends \yii\db\ActiveRecord
{
    public const MAX_NAME_LENGTH = 255;


    /**
     * {@inheritdoc}
     */
    public static function tableName() :string
    {
        return '{{%recipe}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        // @formatter:off
        return [
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['description', 'note'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => self::MAX_NAME_LENGTH],
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
            'id'          => Yii::t( 'common', 'ID' ),
            'user_id'     => Yii::t( 'common', 'User ID' ),
            'name'        => Yii::t( 'common', 'Name' ),
            'description' => Yii::t( 'common', 'Description' ),
            'note'        => Yii::t( 'common', 'Note' ),
            'created_at'  => Yii::t( 'common', 'Created At' ),
            'updated_at'  => Yii::t( 'common', 'Updated At' ),
        ];
    }

    /**
     * Gets query for [[RecipeIngredients]].
     *
     * @return ActiveQuery
     */
    public function getRecipeIngredients() :ActiveQuery
    {
        return $this->hasMany( RecipeIngredient::class, ['recipe_id' => 'id'] );
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
     * @return RecipeQuery the active query used by this AR class.
     */
    public static function find() :RecipeQuery
    {
        return new RecipeQuery( get_called_class() );
    }
}
