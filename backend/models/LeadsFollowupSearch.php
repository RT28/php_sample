<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider; 
use common\models\StudentLeadFollowup;

/**
 * StudentSearch represents the model behind the search form about `common\models\Student`.
 */
class LeadsFollowupSearch extends StudentLeadFollowup
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
        $query = StudentLeadFollowup::find()->orderBy(['id' => SORT_DESC]); 
    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
   
 
        // grid filtering conditions
        $query->andFilterWhere([ 
          'student_id' => $this->student_id, 
        ]);
 
        return $dataProvider;
    }
}
