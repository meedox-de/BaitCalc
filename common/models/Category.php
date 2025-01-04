<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $name
 * @property string      $created_at
 * @property string|null $updated_at
 *
 * @property User        $user
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() :string
    {
        return '{{%category}}';
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
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'id'         => Yii::t( 'common', 'ID' ),
            'user_id'    => Yii::t( 'common', 'User ID' ),
            'name'       => Yii::t( 'common', 'Name' ),
            'created_at' => Yii::t( 'common', 'Created At' ),
            'updated_at' => Yii::t( 'common', 'Updated At' ),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser() :\yii\db\ActiveQuery
    {
        return $this->hasOne( User::class, ['id' => 'user_id'] );
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find() :CategoryQuery
    {
        return new CategoryQuery( get_called_class() );
    }


    public static function getCategoryListForDropdown() :array
    {
        $query = self::find();
        $query->select( [
                            'name',
                            'id',
                        ] );
        $query->userId( Yii::$app->user->id );
        $query->indexBy( 'id' );
        return $query->column();
    }
}
