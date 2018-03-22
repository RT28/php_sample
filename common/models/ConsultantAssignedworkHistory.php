<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "consultant_assignedwork_history".
 *
 * @property integer $id
 * @property integer $consultant_id
 * @property integer $assignedwork_id
 * @property integer $status
 * @property string $comments
 * @property string $created_at
 * @property string $created_by 
 *
 * @property StudentConsultantRelation $consultant
 * @property StudentConsultantRelation $assignedwork
 */
class ConsultantAssignedworkHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consultant_assignedwork_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultant_id', 'assignedwork_id', 'status', 'comments', 'created_at', 'created_by'], 'required'],
            [['consultant_id', 'assignedwork_id', 'status'], 'integer'],
            [['comments'], 'string'],
            [['created_at' ], 'safe'],
            [['created_by' ], 'string', 'max' => 50],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentConsultantRelation::className(), 'targetAttribute' => ['consultant_id' => 'consultant_id']],
            [['assignedwork_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentConsultantRelation::className(), 'targetAttribute' => ['assignedwork_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'consultant_id' => 'Consultant ID',
            'assignedwork_id' => 'Assignedwork ID',
            'status' => 'Status',
            'comments' => 'Comments',
            'created_at' => 'Created At',
            'created_by' => 'Created By', 
        ];
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
    public function getAssignedwork()
    {
        return $this->hasOne(StudentConsultantRelation::className(), ['id' => 'assignedwork_id']);
    }
}
