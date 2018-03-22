<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webinar_students_preferences".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $country
 * @property string $disciplines
 * @property string $degreelevels
 * @property string $university_admission
 * @property string $test_preperation
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property UserLogin $student
 */
class WebinarStudentsPreferences extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webinar_students_preferences';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'country', 'disciplines', 'degreelevels', 'university_admission', 'test_preperation', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['student_id', 'created_by'], 'integer'],
            [['created_at', 'updated_by', 'updated_at'], 'safe'],
            [['country', 'disciplines', 'degreelevels', 'university_admission', 'test_preperation'], 'string', 'max' => 100],
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
            'country' => 'Country',
            'disciplines' => 'Disciplines',
            'degreelevels' => 'Degreelevels',
            'university_admission' => 'University Admission',
            'test_preperation' => 'Test Preperation',
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
