<?php

namespace partner\models;

use Yii;
use yii\base\Model;
use common\models\Country;

/**
 * This is the model class for table "srm".
 *
 * @property integer $id
 * @property integer $srm_id
 * @property string $name
 * @property string $email
 * @property string $gender
 * @property string $mobile
 * @property integer $country
 * @property string $speciality
 * @property string $description
 * @property integer $experience
 * @property string $skills
 * @property string $work_hours_start
 * @property string $work_hours_end
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EmployeeLogin $srm
 * @property Country $country0
 */
class CounselorEnquiry extends Model
{
    

	public $name;
	public $email;
	public $gender;
	public $mobile;
	public $country;
	public $experience;
	public $speciality;
	public $date_of_birth;
	public $description;
	public $skills; 
	public $choosesrm;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'gender', 'mobile', 'country', 'experience', 'speciality', 'date_of_birth'], 'required'],
            [[ 'country', 'experience',], 'integer'],
            [['description'], 'string'],
            [['date_of_birth','choosesrm'], 'safe'],
            [['name', 'email'], 'string', 'max' => 50],
            [['gender'], 'string', 'max' => 1],
            [['mobile'], 'string', 'max' => 20],
            [['skills'], 'string', 'max' => 500],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',   
            'name' => 'Name',
            'email' => 'Email',
            'gender' => 'Gender',
			'date_of_birth' => 'Date of Birth',
            'mobile' => 'Mobile',
            'country' => 'Country',
            'speciality' => 'Speciality',
            'description' => 'Description',
            'experience' => 'Experience',
            'skills' => 'Skills',  			
			'choosesrm' => 'Counselor or Consultant',
        ];
    }
 
 
}

