<?php

namespace partner\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UniversityCommonAdmission;


/**
 * UniversityCommonAdmissionSearch represents the model behind the search form about `common\models\UniversityCommonAdmission`.
 */
class UniversityCommonAdmissionSearch extends UniversityCommonAdmission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'university_id', 'degree_level_id','test_id', 'score'], 'integer'],
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
        $query = UniversityCommonAdmission::find();

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
            'test_id' => $this->test_id,
            'score' => $this->score,
        ]);

        return $dataProvider;
    }
}
