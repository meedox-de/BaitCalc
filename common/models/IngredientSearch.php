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
            [['name'], 'safe'],
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

        $dataProvider = new ActiveDataProvider( [
                                                    'query' => $query,
                                                ] );

        $query->leftJoin( 'category', 'category.id = ingredient.category_id' );

        $this->load( $params );

        if( !$this->validate() )
        {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere( [#
                                    'ingredient.user_id'      => Yii::$app->user->id,
                                ] );

        $query->andFilterWhere( [
                                    'like',
                                    'ingredient.name',
                                    $this->name,
                                ] );

        $query->orderBy( [
                             'ingredient.name' => SORT_ASC,
                         ] );

        return $dataProvider;
    }
}
