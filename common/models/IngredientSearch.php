<?php

namespace common\models;

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
            [['protein', 'fat', 'carbohydrate'], 'number'],
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
    public function search($params) :ActiveDataProvider
    {
        $query = Ingredient::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider( [
                                                    'query' => $query,
                                                ] );

        $this->load( $params );

        if( !$this->validate() )
        {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere( [
                                    'protein'      => $this->protein,
                                    'fat'          => $this->fat,
                                    'carbohydrate' => $this->carbohydrate,
                                ] );

        $query->andFilterWhere( [
                                    'like',
                                    'name',
                                    $this->name,
                                ] );

        $query->orderBy( [
                             'name' => SORT_ASC,
                         ] );

        return $dataProvider;
    }
}
