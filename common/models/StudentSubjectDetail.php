<?php

namespace common\models;
use frontend\models\UserLogin;

use Yii;

/**
 * This is the model class for table "student_subject_detail".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $name
 * @property integer $maximum_marks
 * @property integer $marks_obtained
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserLogin $student
 */
class StudentSubjectDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_subject_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'name', 'maximum_marks', 'marks_obtained', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['student_id', 'maximum_marks', 'marks_obtained', ], 'integer'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'maximum_marks' => 'Maximum Marks',
            'marks_obtained' => 'Marks Obtained',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
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
