<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "student_notifications".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $from_id
 * @property integer $from_role
 * @property string $message
 * @property string $timestamp
 * @property integer $read
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property UserLogin $student
 */
class StudentNotifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'from_id', 'from_role', 'message', 'timestamp'], 'required'],
            [['id', 'student_id', 'from_id', 'from_role', 'read', 'created_by', 'updated_by'], 'integer'],
            [['message'], 'string'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
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
            'from_id' => 'From ID',
            'from_role' => 'From Role',
            'message' => 'Message',
            'timestamp' => 'Timestamp',
            'read' => 'Read',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
