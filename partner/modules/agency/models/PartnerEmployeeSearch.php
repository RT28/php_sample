<?php

namespace partner\modules\agency\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PartnerEmployee;
use common\components\Roles;

 
class PartnerEmployeeSearch extends PartnerEmployee
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            
            [[ 'title',  'code', 'country_id', 'state_id', 'city_id', 'pincode', 
			'experience_years', 'experience_months','created_by', 'updated_by'], 'integer'],
            [['first_name', 'last_name','email', 'mobile','date_of_birth', 'created_at', 'updated_at'], 'safe'], 
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
			
        $query = PartnerEmployee::find()->where(['parent_partner_login_id'=>$partner_id])
		->andWhere(['role_id'=>Roles::ROLE_EMPLOYEE]);

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

        $query->andWhere('partner_employee.first_name LIKE "%' . $this->first_name . '%" ' . 
                'OR partner_employee.last_name LIKE "%' . $this->first_name . '%" '.
                'OR CONCAT(partner_employee.first_name, " ", partner_employee.last_name) LIKE "%' . $this->first_name . '%"')
            ->andWhere('partner_employee.mobile LIKE "%' . $this->mobile . '%" ' . 
                'OR partner_employee.code LIKE "%' . $this->mobile . '%" '.
                'OR CONCAT(partner_employee.code, " ", partner_employee.mobile) LIKE "%' . $this->mobile . '%"')
              
			->andFilterWhere(['like', 'email', $this->email])               
            ->andFilterWhere(['like', 'speciality', $this->speciality])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'skills', $this->skills]);

        return $dataProvider;
    }
}
