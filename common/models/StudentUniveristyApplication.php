<?php

namespace common\models;

use partner\models\PartnerLogin;
use backend\models\EmployeeLogin;
use frontend\models\UserLogin;
use common\models\Student;
use Yii;
use common\models\UniversityCourseList;
/**
 * This is the model class for table "student_univeristy_application".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $srm_id
 * @property integer $consultant_id
 * @property integer $university_id
 * @property integer $course_id
 * @property string $start_term
 * @property integer $status
 * @property string $remarks
 * @property string $summary
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property PartnerLogin $consultant
 * @property UniversityCourseList $course
 * @property EmployeeLogin $srm
 * @property UserLogin $student
 * @property PartnerLogin $university
 * @property PartnerLogin $consultant
 */
class StudentUniveristyApplication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_univeristy_application';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'srm_id', 'university_id', 'course_id', 'start_term', 'created_by', 'updated_by'], 'required'],
            [['student_id', 'srm_id', 'consultant_id', 'university_id', 'course_id', 'status', ], 'integer'],
            [['summary'], 'string'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['start_term'], 'string', 'max' => 50],
            [['remarks'], 'string', 'max' => 500],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['consultant_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniversityCourseList::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['srm_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeLogin::className(), 'targetAttribute' => ['srm_id' => 'id']],
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
            'student_id' => 'Student',
            'srm_id' => 'Srm',
            'consultant_id' => 'Consultant',
            'university_id' => 'University',
            'course_id' => 'Course',
            'start_term' => 'Start Term',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'summary' => 'Summary',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'consultant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(UniversityCourseList::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSrm()
    {
        return $this->hasOne(EmployeeLogin::className(), ['id' => 'srm_id']);
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
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }

     public function getStudentDetails()
    {
       
        return $this->hasOne(Student::className(), ['student_id' => 'student_id']);
    }

}
