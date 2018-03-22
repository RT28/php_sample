<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $consultant_id
 * @property integer $agency_id
 * @property string $refer_number
 * @property string $payment_date
 * @property integer $university
 * @property integer $programme
 * @property string $intake
 * @property integer $gross_tution_fee
 * @property integer $discount
 * @property string $scholarship
 * @property integer $net_fee_paid
 * @property string $invoice_attachment
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $approved
 * @property string $approved_by
 *
 * @property Student $student
 * @property Consultant $consultant
 * @property Agency $agency
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'consultant_id', 'agency_id', 'refer_number', 'payment_date', 'university', 'programme', 'intake', 'gross_tution_fee', 'currency', 'discount', 'scholarship', 'net_fee_paid', 'invoice_attachment','comment', 'created_at', 'updated_at', 'created_by', 'updated_by', 'approved', 'approved_by'], 'required'],
            [['student_id', 'consultant_id', 'agency_id', 'university', 'programme', 'gross_tution_fee','currency', 'discount', 'net_fee_paid', 'status'], 'integer'],
            [['payment_date', 'created_at', 'updated_at', 'approved'], 'safe'],
            ['custom_programme', 'required', 'when' => function ($model) {
                    return $model->programme == '0';
                }, 'whenClient' => "function (attribute, value) {
                        return $('#programme').val() == '0';
                    }"],
            [['refer_number'], 'string', 'max' => 50],
            [['intake', 'scholarship','comment', 'invoice_attachment'], 'string', 'max' => 255],
            [['created_by', 'updated_by', 'approved_by'], 'string', 'max' => 100],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultant::className(), 'targetAttribute' => ['consultant_id' => 'consultant_id']],
            [['agency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agency::className(), 'targetAttribute' => ['agency_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'consultant_id' => 'Consultant ID',
            'agency_id' => 'Agency ID',
            'refer_number' => 'Refer Number',
            'payment_date' => 'Payment Date',
            'university' => 'University',
            'programme' => 'Programme',
            'custom_programme' => 'Custom Programme',
            'intake' => 'Intake',
            'gross_tution_fee' => 'Gross Tution Fee',
            'currency' => 'Currency',
            'discount' => 'Discount',
            'scholarship' => 'Scholarship',
            'comment' => 'Comment',
            'net_fee_paid' => 'Net Fee Paid',
            'invoice_attachment' => 'Evidence Of Fee Payment',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['consultant_id' => 'consultant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgency()
    {
        return $this->hasOne(Agency::className(), ['id' => 'agency_id']);
    }

     public function getConsultantdetails()
    { 
        return $this->hasMany(Consultant::className(), ['consultant_id' => 'consultant_id'])
        ->viaTable('student_consultant_relation', ['student_id' => 'student_id']);
    }
}
