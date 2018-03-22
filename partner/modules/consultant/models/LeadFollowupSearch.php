<?php

namespace partner\modules\consultant\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LeadFollowup;

/**
 * LeadFollowupSearch represents the model behind the search form about `common\models\LeadFollowup`.
 */
class LeadFollowupSearch extends LeadFollowup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'consultant_id', 'created_by', 'status', 'reason_code', 'today_status'], 'integer'],
            [['created_at', 'next_followup', 'next_follow_comment', 'comment', 'comment_date', 'mode'], 'safe'],
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
        $query = LeadFollowup::find();

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
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'next_followup' => $this->next_followup,
            'comment_date' => $this->comment_date,
            'reason_code' => $this->reason_code,
            'today_status' => $this->today_status,
        ]);

        $query->andFilterWhere(['like', 'next_follow_comment', $this->next_follow_comment])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'mode', $this->mode]);

        return $dataProvider;
    }
}
