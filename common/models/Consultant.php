<?php

namespace common\models;

use Yii;
use partner\models\PartnerLogin;
use common\models\Country;

/**
 * This is the model class for table "consultant".
 *
 * @property integer $id
 * @property integer $consultant_id
 * @property string $name
 * @property string $date_of_birth
 * @property string $email
 * @property string $gender
 * @property string $mobile
 * @property integer $country_id
 * @property string $speciality
 * @property string $description
 * @property integer $experience
 * @property string $skills
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PartnerLogin $consultant
 */
class Consultant extends \yii\db\ActiveRecord
{
	
	const STATUS_PENDING = 0;
    const STATUS_INPROGRESS = 1;   
    const STATUS_COMPLETE = 2;
    const STATUS_APPROVE = 3;
    const STATUS_REJECT = 4; 
	
	const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;  
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consultant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_partner_login_id','consultant_id', 'country_id', 'experience_years', 'experience_months','pincode','is_active','is_featured'], 'integer'],
            [['partner_login_id','title','first_name', 'last_name','date_of_birth',
			'email', 'gender', 'code','mobile', 'country_id', 'experience_years',
			'experience_months','speciality','country_id','pincode','is_active'], 'required'],
            [['parent_partner_login_id','state_id','city_id','address','work_hours_start', 'work_hours_end', 'work_days', 'pincode','date_of_birth', 'created_at', 'updated_at', 'created_by', 'updated_by','degree_level','country_level','standard_test','responsible','languages','logged_status'], 'safe'],
            [['description'], 'string'], 
            [['first_name','last_name', 'email'], 'string', 'max' => 50], 
            [['gender'], 'string', 'max' => 1],
            [['mobile'], 'string', 'max' => 20],
            [[ 'skills'], 'string', 'max' => 500],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['consultant_id' => 'id']],
			[['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title *',
			'consultant_id' => 'Consultant',
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
			'address' => 'Street ',
			'pincode' => 'Zip Code ',
            'speciality' => 'Speciality ',
            'description' => 'Description',
            'experience_years' => 'Years  ',
			'experience_months' => 'Months ',
            'skills' => 'Skills',
			'work_hours_start' => 'Working hours Start ',
			'work_hours_end' => 'Working hours End ',
			'work_days' => 'Working Days',
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
     public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
     public function getParentPartner()
    {
        return $this->hasOne(Agency::className(), ['partner_login_id' => 'parent_partner_login_id']);
    }
	
	
	 public static function getConsultantsForAgency($agency) {
        $consultants = Consultant::find()
                    ->where(['parent_partner_login_id' => $agency]) 
                    ->orderBy('first_name')
                    ->all();
        return $consultants;
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
		 Consultant::STATUS_PENDING=>'Pending',
		 Consultant::STATUS_INPROGRESS =>'In Progress', 
		 Consultant::STATUS_COMPLETE=>'Complete',
		 Consultant::STATUS_APPROVE=>'Approve', 
		 Consultant::STATUS_REJECT=>'Reject'
		 ];
    }
	
	public static function getStatusName($code) {
        $status = Consultant::Status();
        return $status[$code];
    }
	
	public static function State()
    {  
         return [
		 Consultant::STATUS_INACTIVE=>'In Active',
		 Consultant::STATUS_ACTIVE =>'Active',  
		 ];
    }
	
	public static function getStateName($code) {
        $status = Consultant::State();
        return $status[$code];
    }
	
}
