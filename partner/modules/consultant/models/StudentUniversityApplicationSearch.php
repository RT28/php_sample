<?php

namespace partner\modules\consultant\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentUniveristyApplication;
use common\components\AdmissionWorkflow;
use common\models\StudentAssociateConsultants;
use common\components\Roles;
use common\models\AssociateConsultants;

/**
 * StudentUniversityApplicationSearch represents the model behind the search form about `common\models\StudentUniveristyApplication`.
 */
class StudentUniversityApplicationSearch extends StudentUniveristyApplication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id',  'consultant_id', 'university_id', 'course_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['start_term', 'remarks', 'summary', 'created_at', 'updated_at'], 'safe'],
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
        if(Yii::$app->user->identity->role_id == Roles::ROLE_CONSULTANT) {
            $consultant_id = Yii::$app->user->identity->id;
        }
        if(Yii::$app->user->identity->role_id == Roles::ROLE_ASSOCIATE_CONSULTANT) {
            $id = Yii::$app->user->identity->id;
            $parentConsultant = AssociateConsultants::find()->where(['=', 'consultant_id', $id])->one();
            $consultant_id = $parentConsultant->parent_consultant_id;
        }
        $students = StudentAssociateConsultants::find()->where(['=', 'associate_consultant_id', Yii::$app->user->identity->id])->all();
        $temp = [];
        foreach($students as $student) {
            array_push($temp, $student->student_id);
        }
        $query = StudentUniveristyApplication::find()->where(['consultant_id' => $consultant_id])->andWhere(['>','status', AdmissionWorkflow::STATE_DRAFT])->andWhere(['in', 'student_id', $temp]);

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
            'student_id' => $this->student_id, 
            'consultant_id' => $this->consultant_id,
            'university_id' => $this->university_id,
            'course_id' => $this->course_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'start_term', $this->start_term])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'summary', $this->summary]);

        return $dataProvider;
    }
}
