<?php

namespace partner\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TaskComment;

/**
 * ConsultantTasksSearch represents the model behind the search form about `common\models\ConsultantTasks`.
 */
class TaskCommentSearch extends TaskComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
       return [
            [['task_id','comment', 'action', 'status', 'created_by', 'created_at'], 'required'],
            [['student_id', 'consultant_id', 'counselor_id', 'action', 'status', 'created_by', 'created_at'], 'integer'],
            [['comment'], 'string'],
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
        $query = TaskComment::find(); 
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
	 

        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
			'task_id' => $this->task_id, 
        ]);
 
        return $dataProvider;
    }
}
