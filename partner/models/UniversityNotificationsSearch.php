<?php

namespace partner\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UniversityNotifications;

/**
 * UniversityNotificationsSearch represents the model behind the search form about `common\models\UniversityNotifications`.
 */
class UniversityNotificationsSearch extends UniversityNotifications
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'university_id'], 'integer'],
            [['title', 'message', 'created_at', 'updated_at'], 'safe'],
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
        $query = UniversityNotifications::find();

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
            'created_at' => $this->created_at, 
            'updated_at' => $this->updated_at, 
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
		->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
