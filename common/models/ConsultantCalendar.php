<?php

namespace common\models;

use Yii;
use partner\models\PartnerLogin;

/**
 * This is the model class for table "consultant_calendar".
 *
 * @property integer $id
 * @property integer $consultant_id
 * @property integer $student_appointment_id
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
 * @property PartnerLogin $consultant
 */
class ConsultantCalendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consultant_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultant_id', 'event_type', 'title', 'start', 'end'], 'required'],
            [['consultant_id', 'student_appointment_id', 'event_type', 'appointment_status', 'created_by', 'updated_by'], 'integer'],
            [['start', 'end', 'created_at', 'updated_at', 'time_stamp'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 500],
            [['remarks'], 'string', 'max' => 200],
            [['time_stamp'], 'string', 'max' => 50],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['consultant_id' => 'id']],
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
            'student_appointment_id' => 'Student Appointment ID',
            'event_type' => 'Event Type',
            'appointment_status' => 'Appointment Status',
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
    public function getConsultant()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'consultant_id']);
    }
}
