<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UniversityCourseList;

/**
 * UniversityCourseListSearch represents the model behind the search form about `common\models\UniversityCourseList`.
 */
class UniversityCourseListSearch extends UniversityCourseList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'university_id', 'degree_id', 'major_id', 'degree_level_id', 'intake', 'fees', 'duration', 'type', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name'], 'safe'],
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
        $query = UniversityCourseList::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			 'pagination' => [
			'pageSize' => 100,
			],
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
            'degree_id' => $this->degree_id,
            'major_id' => $this->major_id,
            'intake' => $this->intake,
            'fees' => $this->fees,
            'duration' => $this->duration,
            'type' => $this->type,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
