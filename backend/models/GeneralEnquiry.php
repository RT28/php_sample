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
class GeneralEnquiry extends \yii\db\ActiveRecord
{
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_REPLIED = 2;
	const STATUS_CLOSED = 3;

	public $agree;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'general_enquiry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'code' ], 'required'],
            [['code','phone', 'status'], 'integer'],
			[['comment', 'status','reply'], 'safe'],
			[['email'], 'unique'], 
            [['message', 'comment','reply'], 'string'],
            [['name'], 'string', 'max' => 255],
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
			'code' => 'Code *',
            'phone' => 'Phone *',  
            'message' => 'Message',
			'reply' => 'Reply',
			'status' => 'Status',
            'comment' => 'Comment',
        ];
    }
	
	public static function status()
    {
         return [  
			GeneralEnquiry::STATUS_INACTIVE => 'In Active',
			GeneralEnquiry::STATUS_ACTIVE => 'Active',
            GeneralEnquiry::STATUS_REPLIED => 'Replied',
            GeneralEnquiry::STATUS_CLOSED => 'Closed', 
        ];
    }
	
}
