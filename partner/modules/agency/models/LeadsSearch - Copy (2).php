<?php

namespace partner\modules\agency\models;

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
    public $srmdetails,$package,$packagedetails,$consultant,$srm,$consultantdetails,$course , $consultant_id ,  $status;
    public function rules()
    {
        return [
            [[ 'city', 'state', 'country', 'created_by', 'updated_by'], 'integer'],
            [['id','first_name', 'last_name', 'date_of_birth', 'gender', 'address', 'street', 'pincode', 'email',  'phone',  'created_at', 'updated_at' ,'srmdetails','srm','package','consultant','packagedetails','consultantdetails','consultant_id','status'], 'safe'],
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
        $query = User::find()->orderBy(['id' => SORT_DESC])
      //  ->joinWith(['srmdetails'])
        ->joinWith(['consultantdetails'])
       // ->joinWith(['student'])
       // ->joinWith(['course'])
        ;
        // add conditions that should always apply here
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
            'date_of_birth' => $this->date_of_birth,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            //'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'consultant.consultant_id' => $this->consultant_id,
            //'status' => $this->status,

        ]);
       

        $query
            ->andWhere('user_login.first_name LIKE "%' . $this->first_name . '%" ' . 
                'OR user_login.last_name LIKE "%' . $this->first_name . '%" '.
                'OR CONCAT(user_login.first_name, " ", user_login.last_name) LIKE "%' . $this->first_name . '%"')
            ->andFilterWhere(['=', 'user_login.follow_status', $this->status])
            ->andFilterWhere(['like', 'user_login.created_at', $this->created_at])
           //  ->andFilterWhere(['like', 'course.name', $this->course])
          //  ->andFilterWhere(['like', 'srm.name', $this->srmdetails])
            ->andFilterWhere(['like', 'consultant.consultant_id', $this->consultant_id])
            

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
