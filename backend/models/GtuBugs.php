<?php

namespace backend\models;

use Yii;
use backend\models\GtuEnvironment;
use backend\models\GtuModule;
/**
 * This is the model class for table "gtu_bugs".
 *
 * @property integer $gt_id
 * @property string $gt_subject
 * @property string $gt_description
 * @property string $gt_steptoreproduce
 * @property string $gt_platform
 * @property string $gt_operatingsystem
 * @property string $gt_browser
 * @property string $gt_url
 * @property string $gt_severity
 * @property integer $gt_envid
 * @property integer $gt_bugmoduleid
 * @property string $gt_createdby
 * @property string $gt_createdon
 * @property string $gt_status
 * @property string $gt_summary
 * @property string $gt_verifiedby
 * @property string $gt_verifiedon
 * @property string $gt_resolvedby
 * @property string $gt_resolvedon
 * @property string $gt_modifiedby
 * @property string $gt_lastmodified
 */
class GtuBugs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gtu_bugs';
    }

    /**
     * @inheritdoc
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
            [['gt_subject', 'gt_description','gt_status','gt_summary', 'gt_severity', 'gt_envid', 'gt_bugmoduleid','gt_createdby','gt_type'/*,  'gt_verifiedby', 'gt_verifiedon', 'gt_resolvedby', 'gt_resolvedon', 'gt_modifiedby', 'gt_lastmodified'*/], 'required'],
            [['gt_description', 'gt_steptoreproduce', 'gt_summary'], 'string'],
            [[ 'gt_verifiedon', 'gt_resolvedon', 'gt_lastmodified','gt_type','gt_platform','gt_operatingsystem', 'gt_browser', 'gt_url', 'gt_assignto','gt_deadline'], 'safe'],
            [['gt_subject'], 'string', 'max' => 300],
            [['gt_platform'], 'string'],
            [[ 'gt_createdby', 'gt_verifiedby', 'gt_resolvedby', 'gt_modifiedby'], 'string', 'max' => 50],
            [['gt_url'], 'string', 'max' => 300],
            [['gt_severity', 'gt_status'], 'string', 'max' => 10],
            //[['gt_status'], 'required', 'on' => 'update']
        ];
    }
public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['gt_status'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */

    
   
     public function uploads()
    {     
            $path_gallery ='uploads/bugs/'. $this->gt_id; 
            if(!file_exists($path_gallery.'/')){ 
                //print_r('file exists');
                $paths = mkdir('uploads/bugs/'. $this->gt_id);
            }
            foreach ($this->imageFiles as $file){
                $file->saveAs('uploads/bugs/'. $this->gt_id. '/' . $file->baseName . '.' . $file->extension, false);
           // print_r($file);
            }
            return true;
            //die();
    }

    public function attributeLabels()
    {
        return [
            'gt_id' => 'ID',
            'gt_subject' => 'Subject',
            'gt_description' => 'Description',
            'gt_steptoreproduce' => 'Step To Reproduce',
            'gt_type'=> 'Type',
            'gt_platform' => 'Platform',
            'gt_operatingsystem' => 'Operating System',
            'gt_browser' => 'Browser',
            'gt_url' => 'Url',
            'gt_severity' => 'Severity',
            'gt_envid' => 'Environment',
            'gt_bugmoduleid' => 'Module',
            'gt_createdby' => 'Created By',
            'gt_createdon' => 'Created On',
            'gt_status' => 'Status',
            'gt_summary' => 'Summary',
            'gt_verifiedby' => 'Verified by',
            'gt_verifiedon' => 'Verified on',
            'gt_resolvedby' => 'Resolved By',
            'gt_resolvedon' => 'Resolved On',
            'gt_modifiedby' => 'Modified By',
            'gt_lastmodified' => 'Last Modified',
            'gt_assignto'=> 'Assign to',
            'gt_deadline' => 'Deadline'
        ];
    }

     public function getEnv()
    {
        return $this->hasOne(GtuEnvironment::className(), ['gt_id' => 'gt_envid']);
    }

     public function getModule()
    {
        return $this->hasOne(GtuModule::className(), ['gt_id' => 'gt_bugmoduleid']);
    }

     public function getEnvName()
    {
        return $this->env->gt_name;
    }
}
