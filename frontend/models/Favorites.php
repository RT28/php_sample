<?php

namespace frontend\models;

use Yii;
use common\models\University;
use common\models\UniversityCourseList;
use common\models\Student;

/**
 * This is the model class for table "favorites".
 *
 * @property integer $gt_id
 * @property integer $student_id
 * @property integer $course_id
 * @property integer $university_id
 *
 * @property University $university
 * @property Student $student
 * @property UniversityCourseList $course
 */
class Favorites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_favourite_courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'course_id', 'university_id'], 'integer'],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['university_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniversityCourseList::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gt_id' => 'Gt ID',
            'student_id' => 'Student ID',
            'course_id' => 'Course ID',
            'university_id' => 'University ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(UniversityCourseList::className(), ['id' => 'course_id']);
    }
}
