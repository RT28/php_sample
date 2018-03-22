<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentPackageDetails;

/**
 * StudentPackageDetailsSearch represents the model behind the search form about `common\models\StudentPackageDetails`.
 */
class StudentPackageDetailsSearch extends StudentPackageDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'package_type_id', 'package_subtype_id', 'limit_type', 'limit_pending', 'created_by', 'updated_by'], 'integer'],
            [['package_offerings', 'created_at', 'updated_at'], 'safe'],
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
        $query = StudentPackageDetails::find();

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
            'package_type_id' => $this->package_type_id,
            'package_subtype_id' => $this->package_subtype_id,
            'limit_type' => $this->limit_type,
            'limit_pending' => $this->limit_pending,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'package_offerings', $this->package_offerings]);

        return $dataProvider;
    }
}
