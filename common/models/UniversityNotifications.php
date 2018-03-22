<?php

namespace common\models;

use Yii; 

/**
 * This is the model class for table "university_notifications".
 *
 * @property integer $id
 * @property integer $university_id
 * @property integer $from_id
 * @property integer $from_role
 * @property string $message
 * @property string $timestamp
 * @property integer $read
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PartnerLogin $university
 */
class UniversityNotifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','message'], 'required'], 
            [['title','message'], 'string'],           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'title' => 'Title',
            'university_id' => 'University ID', 
            'message' => 'Message', 
            'created_at' => 'Created At',
            'updated_at' => 'Updated At', 
        ];
    }
 
}
