<?php

namespace partner\models;
use common\models\University;

use Yii;

/**
 * This is the model class for table "university_notifications".
 *
 * @property integer $id
 * @property integer $university_id 
 * @property string $message 
 * @property string $created_at 
 * @property string $updated_at 
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
            [['id', 'university_id', 'title', 'message' ], 'required'],
            [['id', 'university_id'], 'integer'],
            [['title','message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }
}
