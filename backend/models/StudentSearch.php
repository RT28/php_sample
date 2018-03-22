<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentUniveristyApplication;
use common\models\Student;
/**
 * StudentSearch represents the model behind the search form about `common\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * @inheritdoc
     */
    public $srmdetails,$package,$packagedetails,$consultant,$srm,$consultantdetails,$course;
    public function rules()
    {
        return [
            [[ 'city', 'state', 'country', 'created_by', 'updated_by'], 'integer'],
            [['id','first_name', 'last_name', 'date_of_birth', 'gender', 'address', 'street', 'pincode', 'email',  'phone',   'created_at', 'updated_at' ,'srmdetails','srm','package','consultant','packagedetails','consultantdetails'], 'safe'],
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
        $query = Student::find()
      //  ->joinWith(['srmdetails'])
        ->joinWith(['consultantdetails'])
        ->joinWith(['packagedetails'])
        ->joinWith(['course']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'date_of_birth' => $this->date_of_birth,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
       

        $query
            ->andWhere('student.first_name LIKE "%' . $this->first_name . '%" ' . 
                'OR student.last_name LIKE "%' . $this->first_name . '%" '.
                'OR CONCAT(student.first_name, " ", student.last_name) LIKE "%' . $this->first_name . '%"')
             ->andFilterWhere(['like', 'course.name', $this->course])
           // ->andFilterWhere(['like', 'srm.name', $this->srmdetails])
            ->andFilterWhere(['like', 'consultant.first_name', $this->consultantdetails])
            ->andFilterWhere(['like', 'package_type.name', $this->packagedetails])
            //->andFilterWhere(['like', 'university_course_list.name', $this->course])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'pincode', $this->pincode])
            ->andFilterWhere(['like', 'email', $this->email]) 
            ->andFilterWhere(['like', 'phone', $this->phone]) ;

        return $dataProvider;
    }
}
