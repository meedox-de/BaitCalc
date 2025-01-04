<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * modelsIngredientSearch represents the model behind the search form of `common\models\Ingredient`.
 */
class IngredientSearch extends Ingredient
{
    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        // @formatter:off
        return [
            [['name', 'category_id'], 'safe'],
        ];
        // @formatter:on
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() :array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params) :ActiveDataProvider
    {
        $query = Ingredient::find();

        // add conditions that should always apply here
        $query->leftJoin( 'category', 'category.id = ingredient.category_id' );

        $dataProvider = new ActiveDataProvider( [
                                                    'query' => $query,
                                                    'sort'  => [
                                                        'attributes' => [
                                                            'name',
                                                            'protein',
                                                            'fat',
                                                            'carbohydrate',
                                                            'created_at',
                                                            'category_id' => [
                                                                'asc'     => ['category.name' => SORT_ASC],
                                                                'desc'    => ['category.name' => SORT_DESC],
                                                                'default' => SORT_ASC,
                                                            ],
                                                        ],
                                                    ],
                                                ] );

        $this->load( $params );

        if( !$this->validate() )
        {
            // on validation error return empty data set
            $query->where( '0=1' );
            return $dataProvider;
        }

        // filtering
        $query->andFilterWhere( [
                                    'ingredient.user_id' => Yii::$app->user->id,
                                ] );

        $query->andFilterWhere( [
                                    'ingredient.category_id' => $this->category_id,
                                ] );

        $query->andFilterWhere( [
                                    'like',
                                    'ingredient.name',
                                    $this->name,
                                ] );

        return $dataProvider;
    }
}
