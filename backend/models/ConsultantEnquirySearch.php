<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ConsultantEnquiry;

/**
 * UniversityEnquirySearch represents the model behind the search form about `backend\models\UniversityEnquiry`.
 */
class ConsultantEnquirySearch extends ConsultantEnquiry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           	[[ 'id', 'country_id', 'experience', 'status'], 'integer'],
            [['title','first_name', 'last_name', 'email', 'gender', 'code','mobile', 'country_id',
			'experience', 'created_at', 'updated_at','speciality','country_id'], 'safe'], 
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
        $query = ConsultantEnquiry::find();

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
            'mobile' => $this->mobile, 
            'country_id' => $this->country_id,
			'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name]) 
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
