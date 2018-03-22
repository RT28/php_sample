<?php

namespace common\models;

use Yii; 
use common\models\Country;
use  partner\models\PartnerLogin;
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
class SRM extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	
    public static function tableName()
    {
        return 'srm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'gender', 'mobile', 'country', 'experience', 'speciality',  'created_at', 'updated_at','date_of_birth'], 'required'],
            [['srm_id','university_id','main_srm', 'country', 'experience',], 'integer'],
            [['description'], 'string'],
            [[ 'created_at', 'updated_at', 'date_of_birth','work_hours_start','work_hours_end'], 'safe'],
            [['name', 'email'], 'string', 'max' => 50],
            [['gender'], 'string', 'max' => 1],
            [['mobile'], 'string', 'max' => 20],
            [[ 'skills'], 'string', 'max' => 500],
            [['srm_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['srm_id' => 'id']],
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
            'srm_id' => 'Srm ID',
			'university_id' => 'University',
			'main_srm' => 'Main SRM',
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
}

