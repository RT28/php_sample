<?php

namespace partner\modules\agency\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Consultant;

/**
 * ConsultantSearch represents the model behind the search form about `common\models\consultant`.
 */
class ConsultantSearch extends Consultant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'country_id',   'created_by', 'updated_by'], 'integer'],
            [['first_name', 'last_name','email', 'gender', 'mobile', 'speciality', 'description', 'skills', 'created_at', 'updated_at'], 'safe'],
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
		$partner_id = Yii::$app->user->identity->id; 
        $query = Consultant::find()->where(['parent_partner_login_id'=>$partner_id]); 
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
            'country_id' => $this->country_id,  
        ]);

        $query->andWhere('consultant.first_name LIKE "%' . $this->first_name . '%" ' . 
                'OR consultant.last_name LIKE "%' . $this->first_name . '%" '.
                'OR CONCAT(consultant.first_name, " ", consultant.last_name) LIKE "%' . $this->first_name . '%"')
            ->andWhere('consultant.mobile LIKE "%' . $this->mobile . '%" ' . 
                'OR consultant.code LIKE "%' . $this->mobile . '%" '.
                'OR CONCAT(consultant.code, " ", consultant.mobile) LIKE "%' . $this->mobile . '%"')
              
			->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'gender', $this->gender])
             
            ->andFilterWhere(['like', 'speciality', $this->speciality])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'skills', $this->skills]);

        return $dataProvider;
    }
}
