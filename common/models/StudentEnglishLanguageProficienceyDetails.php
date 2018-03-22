<?php

namespace common\models;
use frontend\models\UserLogin;

use Yii;

/**
 * This is the model class for table "student_english_language_proficiencey_details".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $test_name
 * @property integer $reading_score
 * @property integer $writing_score
 * @property integer $listening_score
 * @property integer $speaking_score
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property UserLogin $student
 */
class StudentEnglishLanguageProficienceyDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_english_language_proficiencey_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'test_name', 'reading_score', 'writing_score', 'listening_score', 'speaking_score', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['student_id', 'reading_score', 'writing_score', 'listening_score', 'speaking_score', 'created_at', 'updated_at'], 'integer'],
            [['created_by', 'updated_by'], 'safe'],
            [['test_name'], 'string', 'max' => 255],
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
            'test_name' => 'Test Name',
            'reading_score' => 'Reading Score',
            'writing_score' => 'Writing Score',
            'listening_score' => 'Listening Score',
            'speaking_score' => 'Speaking Score',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
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
