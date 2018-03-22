<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webinar_students_questions".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $webinar_id
 * @property string $question
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property UserLogin $student
 * @property WebinarCreateRequest $webinar
 */
class WebinarStudentsQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webinar_students_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'webinar_id', 'question', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['student_id', 'webinar_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['question'], 'string', 'max' => 255],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['webinar_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarCreateRequest::className(), 'targetAttribute' => ['webinar_id' => 'id']],
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
            'webinar_id' => 'Webinar ID',
            'question' => 'Question',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinar()
    {
        return $this->hasOne(WebinarCreateRequest::className(), ['id' => 'webinar_id']);
    }
}
