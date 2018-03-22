<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PackageSubtype;
use common\components\PackageLimitType;

/**
 * PackageSubtypeSearch represents the model behind the search form about `common\models\PackageSubtype`.
 */
class PackageSubtypeSearch extends PackageSubtype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'package_type_id', 'fees', 'currency', 'status', 'rank', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'package_offerings', 'created_at', 'updated_at','limit_count', 'limit_type',], 'safe'],
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
        $query = PackageSubtype::find();

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
            'package_type_id' => $this->package_type_id,
            'limit_count' => $this->limit_count,
            'fees' => $this->fees,
            'currency' => $this->currency,
            //'limit_type' => $this->limit_type,
            'status' => $this->status,
            'rank' => $this->rank,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'package_offerings', $this->package_offerings])
             ->andWhere(  
                'CONCAT(package_subtype.limit_count ," ",package_subtype.limit_type) LIKE "%' . $this->limit_count. '%"'
            );

        return $dataProvider;
    }
}
