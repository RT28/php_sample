<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_course_list".
 *
 * @property integer $id
 * @property integer $university_id
 * @property integer $degree_id
 * @property integer $major_id
 * @property integer $degree_level_id
 * @property string $name
 * @property string $description
 * @property integer $intake
 * @property integer $language
 * @property integer $fees
 * @property integer $fees_international_students
 * @property string $duration
 * @property integer $duration_type
 * @property integer $type
 * @property string $standard_test_list
 * @property integer $application_fees
 * @property integer $application_fees_international
 * @property string $careers
 * @property string $eligibility_criteria
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property CourseReviewsRatings[] $courseReviewsRatings
 * @property StudentFavouriteCourses[] $studentFavouriteCourses
 * @property StudentShortlistedCourse[] $studentShortlistedCourses
 * @property StudentUniveristyApplication[] $studentUniveristyApplications
 * @property Degree $degree
 * @property DegreeLevel $degreeLevel
 * @property Majors $major
 * @property University $university
 */
class UniversityCourseList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_course_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['program_code','university_id', 'degree_id', 'major_id', 'degree_level_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'safe'],
            [['university_id', 'degree_id', 'major_id', 'degree_level_id', 'intake',   'duration_type', 'type', 'application_fees', 'application_fees_international', 'rolling','created_by', 'updated_by'], 'integer'],
            [['description',  'program_website'], 'string'],
            [['duration'], 'number'],
            [['created_at', 'updated_at','language', 'standard_test_list'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['careers', 'eligibility_criteria'], 'string'],
            [['program_code','university_id', 'degree_id', 'major_id', 'degree_level_id', 'name'], 'unique', 'targetAttribute' => ['program_code','university_id', 'degree_id', 'major_id', 'degree_level_id', 'name'], 'message' => 'The combination of University ID, Degree ID, Major ID, Degree Level ID, Name has already been taken.'],
            [['degree_id'], 'exist', 'skipOnError' => true, 'targetClass' => Degree::className(), 'targetAttribute' => ['degree_id' => 'id']],
            [['degree_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => DegreeLevel::className(), 'targetAttribute' => ['degree_level_id' => 'id']],
            [['major_id'], 'exist', 'skipOnError' => true, 'targetClass' => Majors::className(), 'targetAttribute' => ['major_id' => 'id']],
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
			'program_code' => 'Program Code',
            'university_id' => 'University',
            'degree_id' => 'Discipline',
            'major_id' => 'Sub Discipline',
            'degree_level_id' => 'Degree Level',
            'name' => 'Program',
            'description' => 'Description',
            'intake' => 'intake',
            'language' => 'Language',
            'fees' => 'Fees',
            'fees_international_students' => 'Fees International Students',
            'duration' => 'Duration',
            'duration_type' => 'Duration Type',
            'type' => 'Course Type',
            'standard_test_list' => 'Standard Test List',
            'application_fees' => 'Application Fees',
            'application_fees_international' => 'Application Fees International Students',
            'careers' => 'Careers',
            'eligibility_criteria' => 'Eligibility Criteria',
			'program_website' => 'Program Website',			
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseReviewsRatings()
    {
        return $this->hasMany(CourseReviewsRatings::className(), ['course_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFavouriteCourses()
    {
        return $this->hasMany(StudentFavouriteCourses::className(), ['course_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentUniveristyApplications()
    {
        return $this->hasMany(StudentUniveristyApplication::className(), ['course_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentShortlistedCourses()
    {
        return $this->hasMany(StudentShortlistedCourse::className(), ['course_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDegree()
    {
        return $this->hasOne(Degree::className(), ['id' => 'degree_id']);
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
    public function getMajor()
    {
        return $this->hasOne(Majors::className(), ['id' => 'major_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }
	
	public function getStandardTests()
    {
        return $this->hasOne(StandardTests::className(), ['id' => 'id']);
    }
	
	public  function getCoursesForUniversity($university_id) {
        $Courses = UniversityCourseList::find()
					->select(['id','name'])
                    ->where(['university_id' => $university_id])
                    ->indexBy('id')
                    ->orderBy('name')
                    ->all();
        return $Courses;
    }
	
}