<?php

namespace common\models;

use Yii;
use backend\models\EmployeeLogin;
use frontend\models\UserLogin;

/**
 * This is the model class for table "free_counselling_sessions".
 *
 * @property integer $id
 * @property string $skype_id
 * @property integer $student_id
 * @property integer $srm_id
 * @property integer $consultant_id
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $created_at
 *
 * @property UserLogin $student
 */
class FreeCounsellingSessions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'free_counselling_sessions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'start_time', 'end_time', 'status', 'created_by', 'updated_at', 'updated_by', 'created_at'], 'required'],
            [['student_id', 'srm_id', 'consultant_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['start_time', 'end_time', 'updated_at', 'created_at'], 'safe'],
            [['skype_id'], 'string', 'max' => 50],
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
            'skype_id' => 'Skype ID',
            'student_id' => 'Student ID',
            'srm_id' => 'Srm ID',
            'consultant_id' => 'Consultant ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
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
