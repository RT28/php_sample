<?php

namespace common\models;

use Yii;
use common\models\Consultant;
use frontend\models\UserLogin; 
/**
 * This is the model class for table "student_consultant_relation".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $consultant_id
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property Student $student
 * @property Consultant $consultant
 */
class StudentConsultantRelation extends \yii\db\ActiveRecord
{
     
	 public $accessoption;
	 
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_consultant_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'agency_id', 'created_by', 'created_at', 'updated_by',
			'updated_at'], 'required'],
            [['student_id', 'agency_id', 'consultant_id', 'is_sub_consultant', 'assigned_work_status'], 'integer'],
			[['comment_by_consultant'], 'string'],
            [['start_date','end_date', 'assigned_work_status','consultant_id', 'parent_consultant_id',  'is_sub_consultant','created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student',
            'consultant_id' => 'Consultant',
			'is_sub_consultant' => 'Is Sub Consultant',
			'start_date' => 'Start Date',
			'end_date' => 'End Date', 
			'comment_by_consultant' => 'Comment By Consultant',
			'assigned_work_status' => 'Work status', 
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['consultant_id' => 'consultant_id']);
    }
	
	  public function getAgency()
    {
        return $this->hasOne(Agency::className(), ['partner_login_id' => 'agency_id']);
    }
	  
}
