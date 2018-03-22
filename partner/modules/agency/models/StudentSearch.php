<?php

namespace partner\modules\agency\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider; 
use common\models\Student;
use frontend\models\UserLogin;
/**
 * StudentSearch represents the model behind the search form about `common\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * @inheritdoc
     */
    public $degree_preference, $country_preference,
	$majors_preference, $begin,
	$package,
	$packagedetails, 
	$consultant, 
	$consultantdetails,
	$employee,
	$package_type,
	$Student
	;
    public function rules()
    {
        return [
            [[ 'phone', 'country', 'created_by', 'updated_by'], 'integer'],
            [['first_name', 'last_name',  'email',  'phone', 
			 'package','consultant','packagedetails',
			'consultantdetails','employee','degree_preference','majors_preference',
			'country_preference','begin', 'package_type', 'Student' ], 'safe'],
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
        $query = Student::find()->distinct() 
		->joinWith(['consultantdetails'])		
        ->joinWith(['packagedetails'])  
		->joinWith(['student']);
		
		  $id = Yii::$app->user->identity->id;
		$query->where(['student_consultant_relation.agency_id'=>$id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([ 
            'student.country' => $this->country,  
        ]);
        
		$query->andWhere('student.first_name LIKE "%' . $this->first_name . '%" ' . 
		'OR student.last_name LIKE "%' . $this->first_name . '%" '.
		'OR CONCAT(student.first_name, " ", student.last_name) LIKE "%' . $this->first_name . '%"')
		->andFilterWhere(['like', 'consultant.first_name', $this->consultantdetails])
		->andFilterWhere(['like', 'student.email', $this->email]) 
		->andFilterWhere(['like', 'student.phone', $this->phone]) ;
		if(isset($this->package_type)){
			$query->andFilterWhere(['in', 'package_type.name', $this->package_type]) ;
		}
		if(isset($this->degree_preference)){
			$query->andFilterWhere(['=', 'user_login.degree_preference', $this->degree_preference]) ;
		}
		if(isset($this->begin)){
			$query->andFilterWhere(['=', 'user_login.begin', $this->begin]) ;
		}
		if(!empty($this->majors_preference)){
			$majors_preference = implode(',',$this->majors_preference);
			$query->andFilterWhere(['like', 'user_login.majors_preference', $majors_preference]) ;
		}	
		if(!empty($this->country_preference)){
			$country_preference = implode(',',$this->country_preference);
			$query->andFilterWhere(['like', 'user_login.country_preference', $country_preference]) ;
		}		
             
  //echo $query->createCommand()->rawSql;

        return $dataProvider;
    }
}
