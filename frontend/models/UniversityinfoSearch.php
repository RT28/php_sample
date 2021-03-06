<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Universityinfo;

/**
 * UniversityinfoSearch represents the model behind the search form about `common\models\Universityinfo`.
 */
class UniversityinfoSearch extends Universityinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'consultant_id', 'university_id', 'created_by', 'updated_by'], 'integer'],
            [['question', 'answer', 'created_at', 'updated_at'], 'safe'],
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
        $query = Universityinfo::find();
         //$id = Yii::$app->user->identity->id;
             //$query->where(['consultant_id'=>$id]);

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
            'consultant_id' => $this->consultant_id,
            'university_id' => $this->university_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['=', 'university_id', $this->university_id])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}