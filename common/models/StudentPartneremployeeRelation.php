<?php

namespace common\models;

use Yii; 
use partner\models\PartnerLogin;
use frontend\models\UserLogin;

/**
 * This is the model class for table "student_partneremployee_relation".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $consultant_id
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_at
 * @property string $updated_by
 * @property integer $parent_employee_id
 * @property string $access_list
 * @property string $start_date
 * @property string $end_date 
 * @property string $comment_by_consultant
 * @property integer $assigned_work_status 
 *
 * @property PartnerLogin $parentEmployee
 */
class StudentPartneremployeeRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_partneremployee_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            [['student_id', 'consultant_id', 'created_by', 'created_at', 'updated_at', 'updated_by', 'parent_employee_id', 'access_list', 'start_date', 'end_date', 'comment_by_consultant', 'assigned_work_status' ], 'required'],
            [['student_id', 'consultant_id', 'created_by', 'updated_at', 'parent_employee_id', 'assigned_work_status'], 'integer'],
            [['created_at', 'updated_by', 'start_date', 'end_date'], 'safe'],
            [['comment_by_consultant' ], 'string'], 
            [['parent_employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['parent_employee_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'consultant_id' => 'Consultant ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'parent_employee_id' => 'Employee/Trainer',
            'access_list' => 'Access List',
            'start_date' => 'Start Date',
            'end_date' => 'End Date', 
            'comment_by_consultant' => 'Comment By Consultant',
            'assigned_work_status' => 'Assigned Work Status', 
        ];
    }

	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id'])
		->viaTable('student_partneremployee_relation', ['student_id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['id' => 'consultant_id']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartnerEmployee()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'parent_employee_id']);
    }
	
	public function getParentEmployee()
    {
        return $this->hasOne(PartnerEmployee::className(), ['partner_login_id' => 'parent_employee_id']);
    }
	
	 
}
