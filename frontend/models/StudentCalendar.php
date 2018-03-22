<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "student_calendar".
 *
 * @property integer $id
 * @property integer $student_id 
 * @property integer $consultant_appointment_id
 * @property integer $event_type
 * @property integer $appointment_status
 * @property string $title
 * @property string $url
 * @property string $remarks
 * @property string $start
 * @property string $end
 * @property string $time_stamp
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property UserLogin $student
 */
class StudentCalendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'event_type', 'title', 'start', 'end'], 'required'],
            [['student_id',  'consultant_appointment_id', 'event_type', 'appointment_status', 'created_by', 'updated_by'], 'integer'],
            [['meetingtype', 'mode','start', 'end', 'created_at', 'updated_at', 'time_stamp'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 500],
            [['remarks'], 'string', 'max' => 200],
            [['time_stamp'], 'string', 'max' => 50],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']],
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
            'consultant_appointment_id' => 'Consultant Appointment ID',
            'event_type' => 'Event Type',
            'appointment_status' => 'Appointment Status',
			'meetingtype' => 'Type',
			'mode' => 'Mode Of Meeting',
            'title' => 'Title',
            'url' => 'Url',
            'remarks' => 'Remarks',
            'start' => 'Start',
            'end' => 'End',
            'time_stamp' => 'Time Stamp',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id']);
    }
}
