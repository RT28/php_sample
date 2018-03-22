<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "document_types".
 *
 * @property integer $document_id
 * @property string $document_name
 * @property string $document_status
 */
class DocumentTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_status'], 'string'],
            [['document_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_id' => 'Document ID',
            'document_name' => 'Document Name',
            'document_status' => 'Document Status',
        ];
    }
	 /**
     * @get all list of document types 
     */
	 public static function getAllDocumentList() {
        $documentlist = DocumentTypes::find()                    
                    ->all();
		//return $documentlist;			
        return ArrayHelper::map($documentlist, 'document_id', 'document_name','document_status');
		
    }
	
	
}
