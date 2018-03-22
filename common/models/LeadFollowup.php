<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lead_followup".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $consultant_id
 * @property integer $created_by
 * @property string $created_at
 * @property integer $status
 * @property string $next_followup
 * @property string $next_follow_comment
 * @property string $comment
 * @property string $comment_date
 * @property string $mode
 * @property integer $reason_code
 * @property integer $today_status
 *
 * @property Student $student
 * @property Consultant $consultant
 */
class LeadFollowup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_followup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'created_by', 'created_at', 'status', 'comment', 'comment_date', 'mode'], 'required'],
            [['student_id', 'consultant_id', 'created_by', 'status', 'today_status', 'reason_code'], 'integer'],

            /*['reason_code', 'required', 'when' => function ($model) {
                    return $model->reason_code = '0';
                }, 'whenClient' => "function (attribute, value) {
                        return $('#reason_code').val() == '0';
                    }"],
            ['next_followup', 'required', 'when' => function ($model) {
                    return $model->status == '1';
                }, 'whenClient' => "function (attribute, value) {
                        return $('#status').val() == '0';
                    }"],
            ['next_follow_comment', 'required', 'when' => function ($model) {
                    return $model->status == '2';
                }, 'whenClient' => "function (attribute, value) {
                        return $('#next_follow_comment').val() == '0';
                    }"],        */
            //[['created_at', 'next_followup', 'comment_date'], 'safe'],
            [['next_follow_comment', 'comment','next_followup' ,'other_follow'], 'string', 'max' => 200],
            [['mode'], 'string', 'max' => 50],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'student_id']],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultant::className(), 'targetAttribute' => ['consultant_id' => 'consultant_id']],
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
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'status' => 'Response',
            'next_followup' => 'Next Followup',
            'next_follow_comment' => 'Next Follow Comment',
            'comment' => 'Comment',
            'comment_date' => 'Comment Date',
            'mode' => 'Mode',
            'reason_code' => 'Reason Code',
            'today_status' => 'Today Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['student_id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['consultant_id' => 'consultant_id']);
    }


    
}
