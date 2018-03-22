<?php

namespace common\models;

use Yii;
use partner\models\PartnerLogin;
use common\models\Country;
 
class ConsultantEnquiry extends \yii\db\ActiveRecord
{
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_REPLIED = 2;
	const STATUS_CLOSED = 3;
	
    public $agree;
	
	
    public static function tableName()
    {
        return 'consultant_enquiry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'country_id',  'created_by', 'updated_by', 'status'], 'integer'],
            [['title','first_name', 'last_name', 'email',  'code','mobile', 'country_id', 'experience', 'created_at', 'updated_at', 'country_id'], 'required'],
            [[ 'created_at', 'updated_at','reply'], 'safe'],
            [['description'], 'string'],
            [['first_name','last_name', 'email'], 'string', 'max' => 50], 
            [['mobile'], 'string', 'max' => 20],
            [[  'comment','reply'], 'string', 'max' => 500],
			['agree', 'required', 'requiredValue' => 1, 'message' => 'You should accept term to use our service']
			
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
            'first_name' => 'First Name *',
			'last_name' => 'Last Name *', 
            'email' => 'Email *',
            'gender' => 'Gender *',
            'code' => 'Code *',
			'mobile' => 'Mobile *',
            'country_id' => 'Country *',
            'speciality' => 'Speciality *',
            'description' => 'Message',
            'experience' => 'Experience *',
            'skills' => 'Skills', 
			'comment' => 'Comments',
			'reply' => 'Reply', 
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
	
	public static function status()
    {
         return [  
			ConsultantEnquiry::STATUS_INACTIVE => 'In Active',
			ConsultantEnquiry::STATUS_ACTIVE => 'Active',
            ConsultantEnquiry::STATUS_REPLIED => 'Replied',
            ConsultantEnquiry::STATUS_CLOSED => 'Closed', 
        ];
    }
}
