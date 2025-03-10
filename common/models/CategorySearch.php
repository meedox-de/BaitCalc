<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CategorySearch represents the model behind the search form of `common\models\Category`.
 */
class CategorySearch extends Category
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
        $query = Category::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider( [
                                                    'query' => $query,
                                                    'sort'  => [
                                                        'attributes' => [
                                                            'name',
                                                            'created_at',
                                                        ],
                                                    ],
                                                ] );

        $this->load( $params );

        if( !$this->validate() )
        {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where( '0=1' );
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere( [
                                    'user_id' => Yii::$app->user->id,
                                ] );

        $query->andFilterWhere( [
                                    'like',
                                    'name',
                                    $this->name,
                                ] );

        return $dataProvider;
    }
}
