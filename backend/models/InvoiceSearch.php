<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Invoice;
use common\models\Student;


/**
 * InvoiceSearch represents the model behind the search form about `common\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    /**
     * @inheritdoc
     */
    //public $University;
    public function rules()
    {
        return [
            [['id', 'consultant_id', 'agency_id', 'programme', 'gross_tution_fee', 'discount', 'net_fee_paid', 'status'], 'integer'],
            [['refer_number','student_id','university', 'payment_date', 'intake', 'scholarship', 'invoice_attachment', 'created_at', 'updated_at', 'created_by', 'updated_by', 'approved', 'approved_by'], 'safe'],
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
        $query = Invoice::find()
        ->joinWith(['student']);
        //->joinWith(['university']);
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
            //'student_id' => $this->student_id,
            'consultant_id' => $this->consultant_id,
            'agency_id' => $this->agency_id,
            'payment_date' => $this->payment_date,
            'university' => $this->university,
            'programme' => $this->programme,
            'gross_tution_fee' => $this->gross_tution_fee,
            'discount' => $this->discount,
            'net_fee_paid' => $this->net_fee_paid,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'approved' => $this->approved,
        ]);

        $query->andWhere('student.first_name LIKE "%' . $this->student_id . '%" ' . 
                'OR student.last_name LIKE "%' . $this->student_id . '%" ')
            ->andFilterWhere(['like', 'university', $this->university])
            ->andFilterWhere(['like', 'refer_number', $this->refer_number])
            ->andFilterWhere(['like', 'intake', $this->intake])
            ->andFilterWhere(['like', 'scholarship', $this->scholarship])
            ->andFilterWhere(['=', 'status', $this->status]);

        return $dataProvider;
    }
}
