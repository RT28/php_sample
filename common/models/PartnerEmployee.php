<?php

namespace common\models;

use Yii;
use partner\models\PartnerLogin;
use common\models\Country;
use common\models\State;
use common\models\City;


/**
 * This is the model class for table "partner_employee".
 *
 * @property integer $id
 * @property integer $partner_login_id
 * @property integer $title
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $email
 * @property string $gender
 * @property integer $code
 * @property string $mobile
 * @property integer $country_id
 * @property integer $state_id
 * @property integer $city_id
 * @property integer $pincode
 * @property string $address
 * @property string $speciality
 * @property string $description
 * @property integer $experience
 * @property string $skills
 * @property string $work_hours_start
 * @property string $work_hours_end
 * @property string $work_days
 * @property integer $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class PartnerEmployee extends \yii\db\ActiveRecord
{
	const STATUS_PENDING = 0;
    const STATUS_INPROGRESS = 1;   
    const STATUS_COMPLETE = 2;
    const STATUS_APPROVE = 3;
    const STATUS_REJECT = 4; 
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_login_id', 'title', 'first_name', 'last_name', 'date_of_birth',
			'email', 'gender', 'code', 'mobile', 'country_id', 'state_id', 'city_id',
			'pincode', 'address','profile_type', 'experience_years', 'experience_months', 
			'work_hours_start', 'work_hours_end', 'work_days',  'created_at', 
			'updated_at'], 'required'],
            [['partner_login_id', 'title', 'code', 'country_id', 'state_id', 'city_id',
			'pincode', 'experience_years','experience_months',], 'integer'],
            [['date_of_birth', 'speciality',  'created_at', 'updated_at', 'created_by', 'updated_by','degree_level','country_level','standard_test','responsible','languages'], 'safe'],
            [['description'], 'string'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 50],
            [['gender'], 'string', 'max' => 1],
            [['mobile', 'work_hours_start', 'work_hours_end'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [[ 'skills'], 'string', 'max' => 500], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_login_id' => 'Partner Login ID',
            'title' => 'Title',
            'first_name' => 'First Name ',
            'last_name' => 'Last Name ',
            'date_of_birth' => 'Date Of Birth ',
            'email' => 'Email ',
            'gender' => 'Gender ',
            'code' => 'Code ',
            'mobile' => 'Mobile ',
            'country_id' => 'Country ',
            'state_id' => 'State ',
            'city_id' => 'City ',
            'pincode' => 'Zip Code ',
            'address' => 'Address',
            'speciality' => 'Speciality ',
            'description' => 'Description',
            'experience_years' => 'Years',
			'experience_months' => 'Months',
            'skills' => 'Skills',
            'work_hours_start' => 'Work Hours Start',
            'work_hours_end' => 'Work Hours End',
            'work_days' => 'Work Days', 			
			'degree_level' => 'Degree Level',
			'country_level' => 'College admission for',
			'standard_test' => 'Test Prep',
			'responsible' => 'Responsible for countries',
            'languages' => 'Languages', 
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function getAllEmployees()
    {
       $Employees = PartnerEmployee::find() 
                    ->orderBy('name')
                    ->all();
		return ArrayHelper::map($Employees, 'partner_login_id', 'name');
     
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartnerLogin()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'partner_login_id']);
    }
	
	   /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'partner_login_id']);
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
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    } 
	
	public function Status()
    {  
         return [
		 PartnerEmployee::STATUS_PENDING=>'Pending',
		 PartnerEmployee::STATUS_INPROGRESS =>'In Progress', 
		 PartnerEmployee::STATUS_COMPLETE=>'Complete',
		 PartnerEmployee::STATUS_APPROVE=>'Approve', 
		 PartnerEmployee::STATUS_REJECT=>'Reject'
		 ];
    }
	
	public static function getStatusName($code) {
        $status = PartnerEmployee::Status();
        return $status[$code];
    }
}
