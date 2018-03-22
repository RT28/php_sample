<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Agency;

/**
 * AgencySearch represents the model behind the search form about `common\models\Agency`.
 */
class AgencySearch extends Agency
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'partner_login_id', 'code', 'mobile', 'country_id', 'state_id', 'city_id',], 'integer'],
            [['name', 'establishment_year', 'email', 'address', 'speciality', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Agency::find();

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
            'partner_login_id' => $this->partner_login_id,
           // 'establishment_year' => $this->establishment_year,
          //  'code' => $this->code,
          //  'mobile' => $this->mobile,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
          //  'pincode' => $this->pincode,
          //  'status' => $this->status,
           // 'created_at' => $this->created_at,
          //  'created_by' => $this->created_by,
          //  'updated_at' => $this->updated_at,
          //  'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
           // ->andFilterWhere(['like', 'email', $this->email])
           // ->andFilterWhere(['like', 'address', $this->address])
           // ->andFilterWhere(['like', 'speciality', $this->speciality])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
