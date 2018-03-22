<?php

namespace common\models;

use Yii;
use frontend\models\UserLogin;
use frontend\models\Favorites;
use common\models\UniversityCourseList;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $first_name
 * @property string $last_name
 * @property string $nationality
 * @property string $date_of_birth
 * @property string $gender
 * @property string $address
 * @property string $street
 * @property string $city
 * @property integer $state
 * @property integer $country
 * @property string $pincode
 * @property string $email 
 * @property string $phone 
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Country $country0
 * @property State $state0
 * @property UserLogin $student
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'first_name', 'last_name',   'date_of_birth', 'gender', 'address', 'country', 'nationality', 'pincode', 'email', 'phone', 'created_at', 'updated_at','degree_preference','majors_preference','qualification','begin'], 'required'],
            [['student_id', 'state', 'country','pincode', 'father_phonecode', 'father_phone','mother_phonecode','mother_phone','code','gender'], 'integer'], 
            [['date_of_birth', 'created_at', 'updated_at','created_by', 'updated_by','language_proficiency','city', 'state' ], 'safe'],
            [['first_name', 'last_name', 'address', 'street', 'father_name','mother_name'], 'string', 'max' => 255],
            [['email','father_email', 'mother_email'], 'string', 'max' => 50],
			 [['email','father_email', 'mother_email'], 'email'],
            [['city'], 'string', 'max' => 100],
            [['pincode'], 'string', 'max' => 10], 
			 [['phone', 'father_phone', 'mother_phone'], 'match', 'pattern'=>"/^(\d{6})|(\d{7})|(\d{8})|(\d{9})|(\d{10})$/", 'message'=>'Please enter valid phone number'], 
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country' => 'id']],
            [['state'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state' => 'id']],
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
            'first_name' => 'First Name *',
            'last_name' => 'Last Name *',
            'nationality' => 'Nationality *',
            'date_of_birth' => 'Date Of Birth *',
            'gender' => 'Gender *',
            'address' => 'Address *',
            'street' => 'Street *',
            'city' => 'City *',
            'state' => 'State',
            'country' => 'Country of Residence *',
            'pincode' => 'Zip Code *',
            'email' => 'Email *', 
			'code' => 'Code *',
			'father_name' => 'Father Name',
			'father_email' => 'Father Email',
			'father_phonecode' => 'Code',
			'father_phone' => 'Father Phone Number',
			'mother_name' => 'Mother Name',
			'mother_email' => 'Mother Email',
			'mother_phonecode' => 'Code',
			'mother_phone' => 'Mother Phone Number', 
			'language_proficiency' => 'Language Proficiency ',
            'phone' => 'Phone *', 
            'degree_preference' => 'Degree Preference',
            'majors_preference' => 'Discipline Preference',
            'qualification' => 'Highest Qualification',
            'begin' => 'Enrollment Year',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry0()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState0()
    {
        return $this->hasOne(State::className(), ['id' => 'state']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id']);
    }
 
     public function getConsultant()
    { 
 
	   return $this->hasOne(Consultant::className(), ['consultant_id' => 'consultant_id'])
        ->viaTable('student_consultant_relation', ['student_id' => 'student_id']);
    }
	
	   public function getParentConsultant()
    { 
 
	   return $this->hasOne(Consultant::className(), ['consultant_id' => 'parent_consultant_id'])
        ->viaTable('student_consultant_relation', ['student_id' => 'student_id']);
    }
	
	  public function getEmployee()
    { 
 
	   return $this->hasOne(PartnerEmployee::className(), ['partner_login_id' => 'parent_employee_id'])
        ->viaTable('student_partneremployee_relation', ['student_id' => 'student_id']);
    }
 

     public function getConsultantdetails()
    { 
        return $this->hasMany(Consultant::className(), ['consultant_id' => 'consultant_id'])
        ->viaTable('student_consultant_relation', ['student_id' => 'student_id']);
    }
     public function getLeadsfollowupdetails()
    { 
         return $this->hasMany(LeadFollowup::className(), ['student_id' => 'student_id']);
 
    }

     public function getPackagedetails()
    { 
        return $this->hasMany(PackageType::className(), ['id' => 'package_type_id'])
        ->viaTable('student_package_details', ['student_id' => 'student_id']);
    }

    public function getCourse()
    { 
        return $this->hasMany(UniversityCourseList::className(), ['id' => 'course_id'])
        ->viaTable('student_favourite_courses', ['student_id' => 'student_id']);
    } 
	
	  public function getAgency()
    { 
 
	   return $this->hasOne(Agency::className(), ['partner_login_id' => 'agency_id'])
        ->viaTable('student_consultant_relation', ['student_id' => 'student_id']);
    }
	
	 public function getEmployeedetails()
    { 
        return $this->hasMany(PartnerEmployee::className(), ['partner_login_id' => 'parent_employee_id'])
        ->viaTable('student_partneremployee_relation', ['student_id' => 'student_id']);
    }
}
