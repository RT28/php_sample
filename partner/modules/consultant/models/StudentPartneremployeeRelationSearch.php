<?php
namespace partner\modules\consultant\models; 
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentPartneremployeeRelation;

/**
 * StudentPartneremployeeRelation represents the model behind the search form about `common\models\StudentConsultantRelation`.
 */
class StudentPartneremployeeRelationSearch extends StudentPartneremployeeRelation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'consultant_id','assigned_work_status'], 'integer'],
            [['comment_by_consultant', 'created_by', 'created_at', 'updated_at', 'updated_by'], 'safe'],
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
        $query = StudentPartneremployeeRelation::find();
 

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
            'assigned_work_status' => $this->assigned_work_status,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by, 
        ]);

        $query->andFilterWhere(['like', 'comment_by_consultant', $this->comment_by_consultant]) 
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
