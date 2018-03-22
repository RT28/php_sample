<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertisement".
 *
 * @property integer $id
 * @property string $pagename
 * @property string $image
 * @property string $code
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Advertisement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertisement';
    }

    /**
     * @inheritdoc
     */
	 
    public function rules() 
    {
        return [
            [['pagename', 'imagetitle','redirectlink','rank', 'section','position', 'height','width', 'startdate', 'enddate', 'timing', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['advertisementcode'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['pagename'], 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'string', 'max' => 50],
        ];
    } 

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pagename' => 'Page Name',
            'imageadvert' => 'Image',
            'advertisementcode' => 'Advertisement Code',
			'imagetitle' => 'Advertisement Title',
			'section' => 'Section',
            'section' => 'Position',
			'height' => 'Height',
			'width' => 'Width',
			'startdate' => 'Start Date',
			'enddate' => 'End Date',
			'rank' => 'Rank',
			'timing' => 'Timing', 
			'redirectlink' => 'Redirect Link',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
