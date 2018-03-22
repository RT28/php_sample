<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentUniveristyApplication;
use common\models\UniversityCourseList;
use common\components\AdmissionWorkflow;

/**
 * StudentUniversityApplicationSearch represents the model behind the search form about `common\models\StudentUniveristyApplication`.
 */
class StudentApplicationSearch extends StudentUniveristyApplication
{
    public $studentDetails,$university;
    public $course;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['university','course','studentDetails'], 'safe'],
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['start_term', 'remarks', 'summary', 'created_at', 'updated_at','student_id', 'srm_id', 'consultant_id', 'course_id','university_id',], 'safe'],
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
        //$query = StudentUniveristyApplication::find()->where(['srm_id' => Yii::$app->user->identity->id])->andWhere(['>','status', AdmissionWorkflow::STATE_DRAFT]);
        $query = StudentUniveristyApplication::find()->joinWith('course')
        ->joinWith(['university'])  
        ->joinWith(['studentDetails']);
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
            //'student_id' => $this->student_id,
            //'srm_id' => $this->srm_id,
            //'consultant_id' => $this->consultant_id,
            //'university_id' => $this->university_id,
            //'course_id' => $this->course_id,
            'student_univeristy_application.status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query
           
            ->andWhere('student.first_name LIKE "%' . $this->studentDetails . '%" ' . 
                'OR student.last_name LIKE "%' . $this->studentDetails . '%" '. 
                'OR CONCAT(student.first_name, " ", student.last_name) LIKE "%' . $this->studentDetails . '%"'            )
            ->andFilterWhere(['like', 'university.name', $this->university_id])
            ->andFilterWhere(['like', 'university_course_list.name', $this->course_id])
            ->andFilterWhere(['like', 'start_term', $this->start_term])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'summary', $this->summary]);

        return $dataProvider;
    }
}
