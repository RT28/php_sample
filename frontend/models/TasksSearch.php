<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tasks;

/**
 * ConsultantTasksSearch represents the model behind the search form about `common\models\ConsultantTasks`.
 */
class TasksSearch extends Tasks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','task_category_id', 'task_list_id','student_id', 'action','verifybycounselor', 'specific_alert','standard_alert', 'responsibility','status'], 'integer'],
            [['title', 'notified', 'description', 'due_date', 'comments', 'attachment', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'safe'],
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
        $query = TasksSearch::find();

		 // add conditions that should always apply here
		 
		$id = Yii::$app->user->identity->student->id;  
		$query->where(['student_id'=>$id])
		  ->andFilterWhere(['!=', 'task_list_id', '24'])
		  ->andFilterWhere(['!=', 'due_date', 'NULL']); 
		
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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
			'student_id' => $this->student_id,
            'consultant_id' => $this->consultant_id,
            'task_category_id' => $this->task_category_id,
            'task_list_id' => $this->task_list_id,
            'responsibility' => $this->responsibility,
			'action' => $this->action, 
			'verifybycounselor' => $this->verifybycounselor, 
            'status' => $this->status, 
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'comments', $this->comments]) ;
		 
	/*if (!is_null($this->created_at) && 
	strpos($this->created_at, ' - ') !== false ) {
	list($start_date, $end_date) = explode(' - ', $this->created_at);
	$query->andFilterWhere(['between', 'date(created_at)', $start_date, $end_date]);
	}*/

	
	
	 if(isset ($this->created_at)&&$this->created_at!=''){ //you dont need the if function if yourse sure you have a not null date
              $date_explode=explode(" - ",$this->created_at);
              $date1=trim($date_explode[0]);
              $date2=trim($date_explode[1]);
              $query->andFilterWhere(['between','created_at',$date1,$date2]);
            }
			
			
	 if(isset ($this->due_date)&&$this->due_date!=''){ //you dont need the if function if yourse sure you have a not null date
              $date_explode=explode(" - ",$this->due_date);
              $date1=trim($date_explode[0]);
              $date2=trim($date_explode[1]);
              $query->andFilterWhere(['between','due_date',$date1,$date2]);
            }

			
	/*if (!is_null($this->due_date) && 
	strpos($this->due_date, ' - ') !== false ) {
	list($dstart_date, $dend_date) = explode(' - ', $this->due_date);
	$query->andFilterWhere(['between', 'date(due_date)', $dstart_date, $dend_date]);
	}*/
	
		/*if(isset ($this->due_date)&&$this->due_date!=''){ 
              $date_explode=explode(" - ",$this->due_date);
              $date1=trim($date_explode[0]);
              $date2=trim($date_explode[1]);
              $query->andFilterWhere(['between',"(date_format( `due_date`, '%Y-%m-%d' ))",$date1,$date2]);
        }*/
		
// echo $query->createCommand()->rawSql;
		 
        return $dataProvider;
    }
}
