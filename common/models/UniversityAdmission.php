<?php

namespace common\models;

use Yii;
use common\models\DegreeLevel;
use common\models\UniversityCourseList;


/**
 * This is the model class for table "university_admission".
 *
 * @property integer $id
 * @property integer $university_id
 * @property integer $degree_level_id
 * @property integer $course_id
 * @property string $start_date
 * @property string $end_date
 * @property integer $intake
 * @property string $admission_link
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 
 * @property DegreeLevel $degreeLevel
 * @property University $university
 */
class UniversityAdmission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_admission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['university_id', 'degree_level_id', 'course_id', 'end_date', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'safe'],
            [['university_id', 'degree_level_id', 'course_id', 'intake', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['admission_link'], 'string', 'max' => 500],
            [['degree_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => DegreeLevel::className(), 'targetAttribute' => ['degree_level_id' => 'id']],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['university_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'university_id' => 'University',
            'degree_level_id' => 'Degree Level', 
            'course_id' => 'Programme', 
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'intake' => 'Intake',
            'admission_link' => 'Admission Link',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDegreeLevel()
    {
        return $this->hasOne(DegreeLevel::className(), ['id' => 'degree_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }
	
	 public function getUniversityCourseList()
    {
        return $this->hasOne(UniversityCourseList::className(), ['id' => 'course_id']);
    }
}