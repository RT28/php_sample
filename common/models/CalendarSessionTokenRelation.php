<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "calendar_session_token_relation".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $srm_id
 * @property integer $consultant_id
 * @property string $time_stamp
 * @property string $session_id
 * @property string $start
 * @property string $end
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class CalendarSessionTokenRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_session_token_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'consultant_id', 'created_by', 'updated_by'], 'integer'],
            [['time_stamp', 'session_id', 'start', 'end'], 'required'],
            [['start', 'end', 'created_at', 'updated_at'], 'safe'],
            [['time_stamp'], 'string', 'max' => 50],
            [['session_id'], 'string', 'max' => 200],
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
            'time_stamp' => 'Time Stamp',
            'session_id' => 'Session ID',
            'start' => 'Start',
            'end' => 'End',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}
