<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GtuBugs;

/**
 * GtuBugsSearch represents the model behind the search form about `backend\models\GtuBugs`.
 */
class GtuBugsSearch extends GtuBugs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gt_id', 'gt_envid', 'gt_bugmoduleid'], 'integer'],
            [['gt_subject', 'gt_description', 'gt_steptoreproduce', 'gt_platform', 'gt_operatingsystem', 'gt_browser', 'gt_url', 'gt_severity', 'gt_createdby', 'gt_createdon', 'gt_status', 'gt_summary', 'gt_verifiedby', 'gt_verifiedon', 'gt_resolvedby', 'gt_resolvedon', 'gt_modifiedby', 'gt_lastmodified','gt_type','gt_assignto','gt_deadline'], 'safe'],
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
        $query = GtuBugs::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => ['defaultOrder' => ['gt_createdon' => SORT_DESC]],
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
            'gt_envid' => $this->gt_envid,
            'gt_bugmoduleid' => $this->gt_bugmoduleid,
            'gt_createdon' => $this->gt_createdon,
            'gt_verifiedon' => $this->gt_verifiedon,
            'gt_resolvedon' => $this->gt_resolvedon,
            'gt_lastmodified' => $this->gt_lastmodified,
            'gt_assignto'=>$this->gt_assignto
        ]);

        $query->andFilterWhere(['like', 'gt_subject', $this->gt_subject])
            ->andFilterWhere(['like', 'gt_description', $this->gt_description])
            ->andFilterWhere(['like', 'gt_steptoreproduce', $this->gt_steptoreproduce])
            ->andFilterWhere(['like', 'gt_platform', $this->gt_platform])
            ->andFilterWhere(['like', 'gt_operatingsystem', $this->gt_operatingsystem])
            ->andFilterWhere(['like', 'gt_browser', $this->gt_browser])
            ->andFilterWhere(['like', 'gt_url', $this->gt_url])
            ->andFilterWhere(['like', 'gt_severity', $this->gt_severity])
            ->andFilterWhere(['like', 'gt_createdby', $this->gt_createdby])
            ->andFilterWhere(['like', 'gt_status', $this->gt_status])
            ->andFilterWhere(['like', 'gt_summary', $this->gt_summary])
            ->andFilterWhere(['like', 'gt_verifiedby', $this->gt_verifiedby])
            ->andFilterWhere(['like', 'gt_resolvedby', $this->gt_resolvedby])
            ->andFilterWhere(['like', 'gt_deadline', $this->gt_deadline])
            ->andFilterWhere(['like', 'gt_modifiedby', $this->gt_modifiedby]);

        return $dataProvider;
    }
}
