<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\University;

/**
 * UniversitySearch represents the model behind the search form about `common\models\University`.
 */
class UniversitySearch extends University
{
    /**
     * @inheritdoc
     */
    public $city,$state,$country,$degree_id,$degree_level_id,$major_id; 
    public function rules()
    {
        parent::rules();
        return [
                    
             [['city', 'state','country'], 'safe'],
            
            [['id', 'pincode', 'institution_type', 'establishment', 'no_of_students', 'no_of_international_students', 'no_faculties', 'cost_of_living', 'hostel_strength', 'institution_ranking', 'avg_rating', 'status', 'created_by', 'updated_by', 'reviewed_by'], 'integer'],
            [['name', 'establishment_date', 'address', 'email', 'website', 'description', 'fax', 'phone_1', 'phone_2', 'contact_person', 'contact_person_designation', 'contact_mobile', 'contact_email', 'location', 'video', 'virtual_tour', 'comments', 'created_at', 'updated_at', 'reviewed_at','city_id', 'state_id', 'country_id'], 'safe'],
            [['accomodation_available'], 'boolean'],
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
        $query = University::find();
		 $query->select('university.*, c.major_id, c.degree_id, c.degree_level_id ')->leftJoin('university_course_list as c', 'c.university_id = university.id')
		 ->groupBy('university.id');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]],
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
			'major_id'=>$this->major_id,
			'degree_id'=>$this->degree_id,
			'degree_level_id'=>$this->degree_level_id,
            'country_id'=>$this->country_id,
            'state_id'=>$this->state_id,
            'city_id'=>$this->city_id,
        ]);

        $query->andFilterWhere(['like', 'university.name', $this->name]);

        return $dataProvider;
    }
}
