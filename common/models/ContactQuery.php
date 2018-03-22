<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_query".
 *
 * @property integer $id
 * @property string $first_name 
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property string $source
 * @property string $created_at
 */
class ContactQuery extends \yii\db\ActiveRecord
{
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_REPLIED = 2;
	const STATUS_CLOSED = 3;
	
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
            [['name',  'email', 'phone', 'message'], 'required'],
            [['created_at','code'], 'safe'],
            [['name',  'email'], 'string', 'max' => 50],
            [['phone'], 'integer'],
			[['email'], 'unique'],
            [['message'], 'string', 'max' => 500],
            [['source'], 'string', 'max' => 200],
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
            'phone' => 'Phone',
			'code' => 'code',
            'message' => 'Message',
            'source' => 'Source',
            'created_at' => 'Created At',
        ];
    }
	
	public static function status()
    {
         return [  
			ContactQuery::STATUS_INACTIVE => 'In Active',
			ContactQuery::STATUS_ACTIVE => 'Active',
            ContactQuery::STATUS_REPLIED => 'Replied',
            ContactQuery::STATUS_CLOSED => 'Closed', 
        ];
    }
}
