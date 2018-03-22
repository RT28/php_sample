<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentTasks;

/**
 * StudentTasksSearch represents the model behind the search form about `common\models\StudentTasks`.
 */
class StudentTasksSearch extends StudentTasks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_category_id', 'task_list_id', 'status'], 'integer'],
            [['title', 'description', 'due_date', 'comments', 'attachment', 'created_by', 'updated_by'], 'safe'],
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
        $query = StudentTasks::find();

        // add conditions that should always apply here
		$id = Yii::$app->user->identity->student->id;
		$query->where(['student_id'=>$id]);
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

 
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
           
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'task_category_id' => $this->task_category_id,
            'task_list_id' => $this->task_list_id,
           // 'due_date' => $this->due_date,
           // 'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
          //  ->andFilterWhere(['like', 'description', $this->description])
            //->andFilterWhere(['like', 'comments', $this->comments])
           // ->andFilterWhere(['like', 'attachment', $this->attachment])
           // ->andFilterWhere(['like', 'created_by', $this->created_by])
            //->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
