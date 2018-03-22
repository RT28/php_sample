<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GtuEnvironment;

/**
 * GtuEnvironmentSearch represents the model behind the search form about `backend\models\GtuEnvironment`.
 */
class GtuEnvironmentSearch extends GtuEnvironment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gt_id'], 'integer'],
            [['gt_name'], 'safe'],
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
        $query = GtuEnvironment::find();

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
            'gt_id' => $this->gt_id,
        ]);

        $query->andFilterWhere(['like', 'gt_name', $this->gt_name]);

        return $dataProvider;
    }
}
