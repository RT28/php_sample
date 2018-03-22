<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Emailenquiry;

/**
 * EmailenquirySearch represents the model behind the search form about `common\models\Emailenquiry`.
 */
class EmailenquirySearch extends Emailenquiry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'consultant_id', 'is_to_student', 'is_to_father', 'is_to_mother', 'created_by', 'updated_by'], 'integer'],
            [['subject', 'consultant_message', 'created_at', 'updated_at'], 'safe'],
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
        $query = Emailenquiry::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $status = Yii::$app->request->get('status');
        $query->andFilterWhere([
            'id' => $this->id,
            'student_id' => $this->student_id,
            'consultant_id' => $this->consultant_id,
            'is_to_student' => $this->is_to_student,
            'is_to_father' => $this->is_to_father,
            'is_to_mother' => $this->is_to_mother,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['=', 'email_source', $status])
            ->andFilterWhere(['like', 'consultant_message', $this->consultant_message]);

        return $dataProvider;
    }
}