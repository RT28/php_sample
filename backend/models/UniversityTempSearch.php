<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UniversityTemp;

/**
 * UniversityTempSearch represents the model behind the search form about `common\models\UniversityTemp`.
 */
class UniversityTempSearch extends UniversityTemp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'university_id', 'is_partner', 'establishment_date', 'city_id', 'state_id', 'country_id', 'institution_type', 'establishment', 'no_of_students', 'no_of_undergraduate_students', 'no_of_post_graduate_students', 'no_of_international_students', 'no_faculties', 'no_of_international_faculty', 'cost_of_living', 'undergarduate_fees', 'undergraduate_fees_international_students', 'post_graduate_fees', 'post_graduate_fees_international_students', 'hostel_strength', 'avg_rating', 'currency_id', 'currency_international_id', 'status'], 'integer'],
            [['name', 'address', 'pincode', 'email', 'website', 'description', 'fax', 'phone_1', 'phone_2', 'contact_person', 'contact_person_designation', 'contact_mobile', 'contact_email', 'location', 'institution_ranking', 'video', 'virtual_tour', 'standard_test_list', 'achievements', 'comments', 'created_by', 'created_at', 'updated_by', 'updated_at', 'reviewed_by', 'reviewed_at'], 'safe'],
            [['accomodation_available', 'standard_tests_required'], 'boolean'],
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
        $query = UniversityTemp::find();

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
            'university_id' => $this->university_id,
            'is_partner' => $this->is_partner,
            'establishment_date' => $this->establishment_date,
            'city_id' => $this->city_id,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'institution_type' => $this->institution_type,
            'establishment' => $this->establishment,
            'no_of_students' => $this->no_of_students,
            'no_of_undergraduate_students' => $this->no_of_undergraduate_students,
            'no_of_post_graduate_students' => $this->no_of_post_graduate_students,
            'no_of_international_students' => $this->no_of_international_students,
            'no_faculties' => $this->no_faculties,
            'no_of_international_faculty' => $this->no_of_international_faculty,
            'cost_of_living' => $this->cost_of_living,
            'undergarduate_fees' => $this->undergarduate_fees,
            'undergraduate_fees_international_students' => $this->undergraduate_fees_international_students,
            'post_graduate_fees' => $this->post_graduate_fees,
            'post_graduate_fees_international_students' => $this->post_graduate_fees_international_students,
            'accomodation_available' => $this->accomodation_available,
            'hostel_strength' => $this->hostel_strength,
            'avg_rating' => $this->avg_rating,
            'standard_tests_required' => $this->standard_tests_required,
            'currency_id' => $this->currency_id,
            'currency_international_id' => $this->currency_international_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'reviewed_at' => $this->reviewed_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'pincode', $this->pincode])
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
            ->andFilterWhere(['like', 'institution_ranking', $this->institution_ranking])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'virtual_tour', $this->virtual_tour])
            ->andFilterWhere(['like', 'standard_test_list', $this->standard_test_list])
            ->andFilterWhere(['like', 'achievements', $this->achievements])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'reviewed_by', $this->reviewed_by]);

        return $dataProvider;
    }
}
