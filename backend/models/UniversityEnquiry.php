<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "university_enquiry".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $phone
 * @property string $institute_name
 * @property string $institute_website
 * @property integer $institute_type
 * @property integer $country
 * @property string $message
 */
class UniversityEnquiry extends \yii\db\ActiveRecord
{
	
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_REPLIED = 2;
	const STATUS_CLOSED = 3;
	
	public $username;
	public $agree;
	
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_enquiry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'institute_name', 'institution_type', 'country_id', 'code','agree','message'], 'required'],
            [['phone', 'institution_type', 'country_id', 'status', 'code'], 'integer'],
			[['email'], 'unique'], 
			[['reply'], 'safe'], 
            [['message', 'comment','reply'], 'string'],
            [['name', 'institute_name', 'institute_website'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50],
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
            'name' => 'Name *',
            'email' => 'Email *', 
			'code' => 'code *',
            'phone' => 'Phone *',
            'institute_name' => 'Institute Name *',
            'institute_website' => 'Website',
            'institution_type' => 'Institute Type *',
            'country_id' => 'Country *',
            'message' => 'Message',
			'status' => 'Status',
            'comment' => 'Comment',
        ];
    }
	
	public static function status()
    {
         return [  
			UniversityEnquiry::STATUS_INACTIVE => 'In Active',
			UniversityEnquiry::STATUS_ACTIVE => 'Active',
            UniversityEnquiry::STATUS_REPLIED => 'Replied',
            UniversityEnquiry::STATUS_CLOSED => 'Closed', 
        ];
    }
	
}
