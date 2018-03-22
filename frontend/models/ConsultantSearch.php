<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Consultant;
use common\components\Roles;

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
            [['country', ], 'integer'],
            [['first_name', 'last_name','email', 'speciality', 'skills'], 'safe'],
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
        $query = Consultant::find()->innerJoin('partner_login', '`partner_login`.`id` = `consultant`.`consultant_id` AND `partner_login`.`role_id` = ' . Roles::ROLE_CONSULTANT);
		
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) { 
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'country_id' => $this->country_id,
            'experience_years' => $this->experience_years,
			'experience_months' => $this->experience_months, 
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])  
            ->andFilterWhere(['like', 'speciality', $this->speciality]) 
            ->andFilterWhere(['like', 'skills', $this->skills]);

        return $dataProvider;
    }
}
