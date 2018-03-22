<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\City;

/**
 * CitySearch represents the model behind the search form about `common\models\City`.
 */
class CitySearch extends City
{
    /**
     * @inheritdoc
     */
    public $country,$state;
    public function rules()
    {
        return [
            [['id',], 'integer'],
            [['name','state_id', 'country_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
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
    public function search($params)
    {
        $query = City::find()->joinWith(['country'])->joinWith(['state']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
           // 'status' => $this->status,
            //'country_id' => $this->country_id,
        ]);

        $query->andFilterWhere(['like', 'city.name', $this->name])
        ->andFilterWhere(['like', 'state.name', $this->state_id])
        ->andFilterWhere(['like', 'country.name', $this->country_id]);

        return $dataProvider;
    }
}
