<?php

namespace common\models;

use Yii;
use frontend\models\UserLogin;

/**
 * This is the model class for table "university".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_partner
 * @property integer $establishment_date
 * @property string $address
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $country_id
 * @property string $pincode
 * @property string $email
 * @property string $website
 * @property string $description
 * @property string $fax
 * @property string $phone_1
 * @property string $phone_2
 * @property string $contact_person
 * @property string $contact_person_designation
 * @property string $contact_mobile
 * @property string $contact_email
 * @property string $location
 * @property integer $institution_type
 * @property integer $establishment
 * @property integer $no_of_students
 * @property integer $no_of_undergraduate_students
 * @property integer $no_of_post_graduate_students
 * @property integer $no_of_international_students
 * @property integer $no_faculties
 * @property integer $no_of_international_faculty
 * @property integer $currency_id
 * @property integer $currency_international_id
 * @property integer $cost_of_living
 * @property integer $undergarduate_fees
 * @property integer $undergraduate_fees_international_students
 * @property integer $post_graduate_fees
 * @property integer $post_graduate_fees_international_students
 * @property boolean $accomodation_available
 * @property integer $hostel_strength
 * @property string $institution_ranking
 * @property string $video
 * @property string $virtual_tour
 * @property integer $avg_rating
 * @property boolean $standard_tests_required
 * @property string $achievements
 * @property string $comments
 * @property integer $status
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 * @property integer $reviewed_by
 * @property string $reviewed_at
 *
 * @property CourseReviewsRatings[] $courseReviewsRatings
 * @property StudentFavouriteCourses[] $studentFavouriteCourses
 * @property StudentFavouriteUniversities[] $studentFavouriteUniversities
 * @property StudentUniveristyApplication[] $studentUniveristyApplications
 * @property City $city
 * @property Country $country
 * @property Currency $currency
 * @property State $state
 * @property UniversityAdmission[] $universityAdmissions
 * @property UniversityCourseList[] $universityCourseLists
 * @property UniversityReviewsRatings[] $universityReviewsRatings
 * @property UserLogin[] $students
 */
class University extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	 
	public $universityRankings;
	public $universityVideos;
	
    public static function tableName()
    {
        return 'university';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'city_id', 'state_id', 'country_id', 'pincode', 'email', 'website', 'description', 'phone_1', 'currency_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['establishment_date', 'city_id', 'state_id', 'country_id', 'institution_type', 'establishment', 'no_of_students', 'no_of_undergraduate_students', 'no_of_post_graduate_students', 'no_of_international_students', 'no_faculties', 'no_of_international_faculty', 'currency_id', 'currency_international_id', 'cost_of_living', 'undergarduate_fees', 'undergraduate_fees_international_students', 'post_graduate_fees', 'post_graduate_fees_international_students', 'hostel_strength', 'avg_rating', 'status', 'reviewed_by','acceptance_rate','ielts','tofel','sat','act','gre','gmat','ib_score','gcse_score','gpa_score'], 'integer'],
            [['description', 'achievements', 'application_requirement','bachelor_requirement','master_requirement','foundation_requirement','doctoral_requirement', 'fees', 'deadlines', 'cost_of_living_text', 'accommodation', 'comments','success_stories','info_for_consultant'], 'string'],
            [['accomodation_available', 'standard_tests_required'], 'boolean'],
            [['created_at', 'updated_at', 'reviewed_at', 'is_partner','is_active','application_web_link','student_facuilty_ratio'], 'safe'],
            [['name', 'address', 'email', 'website', 'contact_person', 'contact_email','application_web_link'], 'string', 'max' => 255],
            [['pincode'], 'string', 'max' => 10],
            [['fax', 'phone_1', 'phone_2'], 'string', 'max' => 20],
            [['contact_person_designation', 'created_by', 'updated_by'], 'string', 'max' => 50],
            [['contact_mobile'], 'string', 'max' => 15],
            [['email', 'contact_email'], 'email'],
            [['video', 'virtual_tour'], 'string', 'max' => 500],
            ['establishment_date', 'isYear'],
            ['establishment_date', 'number'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state_id' => 'id']],
        ];
    }

    public function isYear($attribute){
        if (!preg_match('/^[0-9]{4}$/', $this->$attribute)) {
            $this->addError($attribute, 'must contain only 4 digits.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'University Name',
            'is_partner' => 'Is Partner University',
			'is_active' => 'Is Active',
            'establishment_date' => 'Establishment Year',
            'address' => 'Address',
            'city_id' => 'City',
            'state_id' => 'State',
            'country_id' => 'Country',
            'pincode' => 'Zip Code',
            'email' => 'Email',
            'website' => 'Website',
            'description' => 'Description',
            'fax' => 'Fax',
            'phone_1' => 'Phone 1',
            'phone_2' => 'Phone 2',
            'contact_person' => 'Contact Person',
            'contact_person_designation' => 'Contact Person Designation',
            'contact_mobile' => 'Contact Mobile',
            'contact_email' => 'Contact Email',
            'location' => 'Location',
            'institution_type' => 'Institution Type',
            'establishment' => 'Establishment',
            'no_of_students' => 'No Of Students',
            'no_of_undergraduate_students' => 'No Of Undergraduate Students', 
            'no_of_post_graduate_students' => 'No Of Graduate Students',
            'no_of_international_students' => 'No Of International Students',
            'no_faculties' => 'No Faculties',
            'no_of_international_faculty' => 'No Of International Faculty(%)',
            'currency_id' => 'Currency (Local Student Fees)',
            'currency_international_id' => 'Currency (International Student Fees)',
            'cost_of_living' => 'Cost Of Living',
            'undergarduate_fees' => 'Undergraduate Fees',
            'undergraduate_fees_international_students' => 'Undergraduate Fees International Students',
            'post_graduate_fees' => 'Post Graduate Fees',
            'post_graduate_fees_international_students' => 'Post Graduate Fees International Students',
            'accomodation_available' => 'On Campus Housing Available',
            'hostel_strength' => 'Hostel Strength',
            'institution_ranking' => 'Institution Ranking',
            'entrance_score' => 'Entrance Score',
            'video' => 'Video',
            'virtual_tour' => 'Virtual Tour',
            'avg_rating' => 'Avg Rating',
            'standard_tests_required' => 'Standard Tests Required',
            'achievements' => 'Achievements',
            'comments' => 'Comments',			
            'currency_international_id' => 'Currency International ID',
			'application_requirement' => 'Application Requirements',
            'bachelor_requirement' => 'Bachelor Requirements',
            'master_requirement' => 'Master Requirements',
            'foundation_requirement' => 'Foundation Requirements',
            'doctoral_requirement' => 'Doctoral Requirements',
			'fees' => 'Fees',
			'deadlines' => 'Deadlines',
			'cost_of_living_text' => 'Cost of Living',
			'accommodation' => 'Accommodation',
			'success_stories' => 'Success Stories',
            'info_for_consultant' => 'Information for consultant',
            'status' => 'Status',
            'acceptance_rate' => 'Acceptance Rate',
            'student_facuilty_ratio' => 'Student Facuilty Ratio',
            'ielts' => 'IELTS',
            'tofel' => 'TOFEL',
            'sat' => 'SAT',
            'act' => 'ACT',
            'gre' => 'GRE',
            'gmat' => 'GMAT',
            'ib_score' => 'IB',
            'gcse_score' => 'GCSE',
            'gpa_score' => 'GPA',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'reviewed_by' => 'Reviewed By',
            'reviewed_at' => 'Reviewed At',
        ];
    }

    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFavouriteCourses()
    { 
        return $this->hasMany(StudentFavouriteCourses::className(), ['university_id' => 'id']);
    }

    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getCourseReviewsRatings()
    { 
        return $this->hasMany(CourseReviewsRatings::className(), ['university_id' => 'id']);
    }

    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFavouriteUniversities()
    { 
        return $this->hasMany(StudentFavouriteUniversities::className(), ['university_id' => 'id']); 
    }

    /** 
     * @return \yii\db\ActiveQuery
     */  
    public function getStudentUniveristyApplications()
    {
        return $this->hasMany(StudentUniveristyApplication::className(), ['university_id' => 'id']);
    }

    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversityAdmissions()
    {
        return $this->hasMany(UniversityAdmission::className(), ['university_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversityCourseLists()
    {
        return $this->hasMany(UniversityCourseList::className(), ['university_id' => 'id']);
    }

	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getMajors()
    {
        return $this->hasMany(Majors::className(), ['id' => 'major_id']);
    }
	
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getDegreeLevel()
    {
        return $this->hasMany(DegreeLevel::className(), ['id' => 'degree_level_id']);
    }
	
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversityReviewsRatings()
    {
        return $this->hasMany(UniversityReviewsRatings::className(), ['university_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(UserLogin::className(), ['id' => 'student_id'])->viaTable('university_reviews_ratings', ['university_id' => 'id']);
    }
	
	public function getUniversity($id) {
        return  University::find()->where(['AND',['=', 'id',$id]])->one();
    }
	
	public function getUniversityGallery()
    {
        return $this->hasMany(UniversityGallery::className(),['AND', ['university_id' => 'id'], ['photo_type' => 'photos']]);
    }
}