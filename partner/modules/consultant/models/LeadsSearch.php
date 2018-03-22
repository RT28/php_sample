<?php

namespace partner\modules\consultant\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider; 
use common\models\Student;
use common\models\User;



/**
 * StudentSearch represents the model behind the search form about `common\models\Student`.
 */
class LeadsSearch extends Student
{
    /**
     * @inheritdoc
     */
    public $degree_preference, $country_preference,
    $majors_preference, $begin,$package_type,$srmdetails,$package,$packagedetails,$consultant,$srm,$consultantdetails,$leadsfollowupdetails,$course , $consultant_id ,  $status;
    public function rules()
    {
        return [
            [[ 'city', 'state', 'country', 'created_by', 'updated_by'], 'integer'],
            [['id','first_name', 'last_name', 'date_of_birth', 'gender', 'address', 'street', 'pincode', 'email',  'phone',  'created_at', 'updated_at' ,'srmdetails','srm','package','consultant','packagedetails','consultantdetails','leadsfollowupdetails','consultant_id','status'], 'safe'],
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
         ->joinWith(['leadsfollowupdetails'])
        ->joinWith(['student']);
        
        $id = Yii::$app->user->identity->id;
        $query->where(['student_consultant_relation.consultant_id'=>$id]) ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([ 
            'country' => $this->country,  
        ]);
        $status = Yii::$app->request->get('status');
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
        if($status!=7){
            $query->andFilterWhere(['=', 'user_login.follow_status', $status]);
        }
        /*if($status==4){
             $query->andFilterWhere(['=', 'user_login.status', $status]);
        } */   
        if($status==7){
            $query->andFilterWhere(['like', 'lead_followup.next_followup', date("Y-m-d")]) ;
        }   

        return $dataProvider;
    }
    
}
