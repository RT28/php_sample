<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "student_document".
 *
 * @property integer $student_document_id
 * @property integer $student_id
 * @property integer $document_type_id
 * @property string $document_name
 * @property string $document_file
 * @property string $created_at
 */
class StudentDocument extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'document_type_id'], 'integer'],
            [['created_at'], 'safe'],
            [['document_name', 'document_file'], 'string', 'max' => 255],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_document_id' => 'Student Document ID',
            'student_id' => 'Student ID',
            'document_type_id' => 'Document Type ID',
            'document_name' => 'Document Name',
            'document_file' => 'Document File',
            'created_at' => 'Created At',
        ];
    }
	 /**
      * @Create By :-Pankaj
	  * @Use :- 
      */
	public static function getSudentDocumentById($student_id) {
        $documentlist = DocumentTypes::find()                    
                    ->all();
		//return $documentlist; 			
        return ArrayHelper::map($documentlist, 'document_id', 'document_name','document_status');
		
    }
	
	
}
