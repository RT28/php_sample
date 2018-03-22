<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emailenquiry".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $consultant_id
 * @property string $subject
 * @property string $message
 * @property integer $is_to_student
 * @property integer $is_to_father
 * @property integer $is_to_mother
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Student $student
 * @property Consultant $consultant
 */
class Emailenquiry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emailenquiry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'consultant_id', 'subject', 'consultant_message','student_message','father_message','mother_message', 'is_to_student', 'is_to_father', 'is_to_mother', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['student_id', 'consultant_id', 'is_to_student', 'is_to_father', 'is_to_mother', 'created_by', 'updated_by'], 'integer'],
            [['consultant_message','student_message','father_message','mother_message'], 'string'],
            [['is_draft','created_at', 'updated_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
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
            'subject' => 'Subject',
            'consultant_message' => 'Message',
            'student_message' => 'Message',
            'father_message' => 'Message',
            'mother_message' => 'Message',
            'is_to_student' => 'Student',
            'is_to_father' => 'Father',
            'is_to_mother' => 'Mother',
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
        return $this->hasOne(Student::className(), ['student_id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['consultant_id' => 'consultant_id']);
    }

     public function getConsultantdetails()
    { 
        return $this->hasMany(Consultant::className(), ['consultant_id' => 'consultant_id'])
        ->viaTable('student_consultant_relation', ['student_id' => 'student_id']);
    }
}
