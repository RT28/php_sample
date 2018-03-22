<?php

namespace backend\models;

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
    public $city,$state,$country, $universityGallery;
 	
    public function rules()
    {
        parent::rules();
        return [
                    
             [['city', 'state','country'], 'safe'],
            
            [['id', 'pincode', 'institution_type', 'establishment', 'no_of_students', 'no_of_international_students', 'no_faculties', 'cost_of_living', 'hostel_strength', 'institution_ranking', 'avg_rating', 'status', 'created_by', 'updated_by', 'reviewed_by'], 'integer'],
            [['name', 'establishment_date', 'address', 'email', 'website', 'description',
			'fax', 'phone_1', 'phone_2', 'contact_person', 'contact_person_designation',
			'contact_mobile', 'contact_email', 'location', 'video', 'virtual_tour',
			'comments', 'created_at', 'updated_at', 'reviewed_at','city_id', 'state_id',
			'country_id','universityGallery'], 'safe'],
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
		 //->joinWith(['universityGallery'])
		 
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
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
            'establishment_date' => $this->establishment_date,
            'pincode' => $this->pincode,
            'institution_type' => $this->institution_type,
            'establishment' => $this->establishment,
            'no_of_students' => $this->no_of_students,
            'no_of_international_students' => $this->no_of_international_students,
            'no_faculties' => $this->no_faculties,
            'cost_of_living' => $this->cost_of_living,
            'accomodation_available' => $this->accomodation_available,
            'hostel_strength' => $this->hostel_strength,
            'institution_ranking' => $this->institution_ranking,
            'avg_rating' => $this->avg_rating,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'reviewed_by' => $this->reviewed_by,
            'reviewed_at' => $this->reviewed_at,
            'country_id'=>$this->country_id,
            'state_id'=>$this->state_id,
            'city_id'=>$this->city_id,
        ]);

        $query->andFilterWhere(['like', 'university.name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'phone_1', $this->phone_1])
            ->andFilterWhere(['like', 'phone_2', $this->phone_2])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'contact_person_designation', $this->contact_person_designation])
            ->andFilterWhere(['like', 'contact_mobile', $this->contact_mobile])
            ->andFilterWhere(['like', 'contact_email', $this->contact_email])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'virtual_tour', $this->virtual_tour])
            ->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }
}
