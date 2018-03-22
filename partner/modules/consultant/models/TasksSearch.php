<?php

namespace partner\modules\consultant\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tasks;

/**
 * ConsultantTasksSearch represents the model behind the search form about `common\models\ConsultantTasks`.
 */
class TasksSearch extends Tasks
{
	 public $degree_preference, $country_preference,
	$majors_preference, $begin,
	$package,
	$packagedetails, 
	$consultant, 
	$consultantdetails, 
	$package_type,
	$student,
	$first_name,
	$last_name ;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
	return [
		[['id','task_category_id', 'task_list_id','student_id', 'action','verifybycounselor', 'responsibility','status'], 'integer'],
		[[ 'title', 'notified', 'description', 'due_date', 'comments', 'attachment', 'created_by', 'created_at', 'updated_by', 'updated_at','first_name', 'last_name',  
		 'package','consultant','packagedetails',
		'consultantdetails', 'degree_preference','majors_preference',
		'country_preference', 'begin', 'package_type', 'student' ], 'safe'],
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
        $query = TasksSearch::find()->distinct()		
		 ->joinWith(['student']) 
		  ->joinWith(['consultantdetails']) 
         ->joinWith(['packagedetails']);
 
		 $id = Yii::$app->user->identity->id;
		 $query->where(['tasks.consultant_id'=>$id])
		 ->orWhere(['student_consultant_relation.consultant_id'=>$id])
		 ->orWhere(['student_consultant_relation.parent_consultant_id'=>$id]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			 'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC,'created_at' => SORT_DESC]],
        ]);

        $this->load($params);

		
        if (!$this->validate()) {
            return $dataProvider;
        }
		

        // grid filtering conditions
        $query->andFilterWhere([
            'tasks.id' => $this->id,
			'tasks.student_id' => $this->student_id,
            'tasks.consultant_id' => $this->consultant_id,
            'tasks.task_category_id' => $this->task_category_id,
            'tasks.task_list_id' => $this->task_list_id,
            'tasks.responsibility' => $this->responsibility,
			'tasks.action' => $this->action, 
			'tasks.verifybycounselor' => $this->verifybycounselor,
			'tasks.specific_alert' => $this->specific_alert,
            'tasks.status' => $this->status, 
        ]);

        $query->andFilterWhere(['like', 'tasks.title', $this->title])
            ->andFilterWhere(['like', 'tasks.description', $this->description])
            ->andFilterWhere(['like', 'tasks.comments', $this->comments])
            ->andFilterWhere(['like', 'tasks.attachment', $this->attachment]) ;	
		
		if (!is_null($this->created_at) && 
	strpos($this->created_at, ' - ') !== false ) {
	list($start_date, $end_date) = explode(' - ', $this->created_at);
	$query->andFilterWhere(['between', 'date(tasks.created_at)', $start_date, $end_date]);
	}

	if (!is_null($this->due_date) && 
	strpos($this->due_date, ' - ') !== false ) {
	list($dstart_date, $dend_date) = explode(' - ', $this->due_date);
	$query->andFilterWhere(['between', 'date(due_date)', $dstart_date, $dend_date]);
	}
		 
	 if(isset($this->first_name)){	 
	   $query->andWhere('student.first_name LIKE "%' . $this->first_name . '%" ' . 
		'OR student.last_name LIKE "%' . $this->first_name . '%" '.
		'OR CONCAT(student.first_name, " ", student.last_name) LIKE "%' . $this->first_name . '%"')  ;
	 }	
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
