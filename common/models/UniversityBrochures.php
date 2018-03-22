<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_brouchres".
 *
 * @property integer $id
 * @property integer $university_id
 * @property string $filename
 * @property integer $status
 * @property integer $active
 */
class UniversityBrochures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_brochures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['university_id', 'title', 'filename', 'status', 'active'], 'required'],
            [['university_id', 'status', 'active'], 'integer'],
            [['title','filename'], 'string', 'max' => 255],
        ];
    }
 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'university_id' => 'University ID',
			'document_type' => 'Document Type',
            'title' => 'Title',
			'filename' => 'Filename',
            'status' => 'Status',
            'active' => 'Active', 
			'created_by' => 'Created By', 
			'created_at' => 'Created At',
			'updated_at' => 'Updated At', 
			'updated_by' => 'Updated By', 
			'reviewed_by' => 'Reviewed By',
			'reviewed_at' => 'Reviewed At',
        ];
    }
}
