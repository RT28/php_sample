<?php

namespace partner\modules\university\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UniversityAdmission;

/**
 * UniversityAdmissionSearch represents the model behind the search form about `common\models\UniversityAdmission`.
 */
class UniversityAdmissionSearch extends UniversityAdmission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'university_id', 'degree_level_id', 'course_id', 'intake'], 'integer'],
            [['start_date', 'end_date', 'admission_link', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'safe'],
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
        $query = UniversityAdmission::find();

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
            'university_id' => $this->university_id,
            'degree_level_id' => $this->degree_level_id,
            'course_id' => $this->course_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'intake' => $this->intake,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'admission_link', $this->admission_link])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
