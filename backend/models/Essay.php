<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "essay".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $status
 */
class Essay extends \yii\db\ActiveRecord
{
	
	public $documentupload;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'essay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255], 	
			//[['documentupload'], 'compare', 'compareAttribute'=>'documentupload', 'skipOnEmpty' => true, 'message'=>"Password & Confirm Password do not match"],
			 
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
            'description' => 'Description',
            'status' => 'Status',
        ];
    }
}
