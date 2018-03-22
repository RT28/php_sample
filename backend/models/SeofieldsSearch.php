<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Seofields;

/**
 * SeofieldsSearch represents the model behind the search form about `app\models\GtSeofields`.
 */
class SeofieldsSearch extends Seofields
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gt_id'], 'integer'],
            [['gt_title', 'gt_desccontent', 'gt_keycontent', 'gt_linkurl'], 'safe'],
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
        $query = Seofields::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gt_id' => $this->gt_id,
        ]);

        $query->andFilterWhere(['like', 'gt_title', $this->gt_title])
            ->andFilterWhere(['like', 'gt_desccontent', $this->gt_desccontent])
            ->andFilterWhere(['like', 'gt_keycontent', $this->gt_keycontent])
            ->andFilterWhere(['like', 'gt_linkurl', $this->gt_linkurl]);

        return $dataProvider;
    }
}
