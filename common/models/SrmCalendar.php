<?php

namespace common\models;

use Yii;
use partner\models\PartnerLogin;
/**
 * This is the model class for table "srm_calendar".
 *
 * @property integer $id
 * @property integer $srm_id
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
 * @property EmployeeLogin $srm
 */
class SrmCalendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'srm_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['srm_id', 'event_type', 'title', 'start', 'end'], 'required'],
            [['srm_id', 'student_appointment_id', 'event_type', 'appointment_status', 'created_by', 'updated_by'], 'integer'],
            [['start', 'end', 'created_at', 'updated_at', 'time_stamp'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 500],
            [['remarks'], 'string', 'max' => 200],
            [['time_stamp'], 'string', 'max' => 50],
            [['srm_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeLogin::className(), 'targetAttribute' => ['srm_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'srm_id' => 'Srm ID',
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
    public function getSrm()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'srm_id']);
    }
}
