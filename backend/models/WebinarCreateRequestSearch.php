<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WebinarCreateRequest;

/**
 * WebinarCreateRequestSearch represents the model behind the search form about `common\models\WebinarCreateRequest`.
 */
class WebinarCreateRequestSearch extends WebinarCreateRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['topic', 'date_time', 'author_name','institution_name', 'email', 'phone', 'logo_image', 'duration', 'country', 'disciplines', 'degreelevels', 'university_admission', 'test_preperation', 'created_at', 'updated_at'], 'safe'],
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
        $query = WebinarCreateRequest::find();

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
            'date_time' => $this->date_time,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'topic', $this->topic])
            ->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'institution_name', $this->institution_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'logo_image', $this->logo_image])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'disciplines', $this->disciplines])
            ->andFilterWhere(['like', 'degreelevels', $this->degreelevels])
            ->andFilterWhere(['like', 'university_admission', $this->university_admission])
            ->andFilterWhere(['like', 'test_preperation', $this->test_preperation]);

        return $dataProvider;
    }
}
