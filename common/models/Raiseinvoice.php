<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider; 
use common\models\Student;
use frontend\models\UserLogin;

/**
 * This is the model class for table "student_tasks".
 *
 * @property integer $id
 * @property integer $task_category_id
 * @property integer $task_list_id
 * @property string $title
 * @property string $description
 * @property string $due_date
 * @property string $comments
 * @property string $attachment
 * @property integer $status
 * @property string $created_by
 * @property integer $created_at
 * @property string $updated_by
 * @property integer $updated_at
 *
 * @property TaskCategory $taskCategory
 * @property TaskList $taskList
 */
class Raiseinvoice extends \yii\db\ActiveRecord
{
	 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_category_id', 'task_list_id','student_id','verifybycounselor', 'status','action','notified', 'standard_alert', 'responsibility','created_by', 'created_at'], 'required'],
            [['task_category_id', 'task_list_id', 'status'], 'integer'],
            [['title', 'description', 'comments','additional','others'], 'string'],
            [['due_date', 'specific_alert'], 'safe'],
            [['attachment'], 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'string', 'max' => 50],
            [['task_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskCategory::className(), 'targetAttribute' => ['task_category_id' => 'id']],
            //[['task_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskList::className(), 'targetAttribute' => ['task_list_id' => 'id']],
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
            'task_category_id' => 'Master Task Category',
            'task_list_id' => 'Standard Task',
            'title' => 'Non Standard Task',
            'description' => 'Description',
			'notified' => 'People to be Notified',
			'additional' => 'Additional',
			'standard_alert' => 'Standard Alert',
			'specific_alert' => 'Specific Alert',
			'responsibility' => 'Responsibility',
			'others' => 'Others',
            'due_date' => 'Deadline', 
            'attachment' => 'Attachment', 
			'action' => 'Action', 
			'status' => 'Status', 
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
  
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id'])->viaTable('student', ['student_id' => 'student_id']);
    }
	
	 public function getConsultantdetails()
    { 
        return $this->hasMany(Consultant::className(), ['consultant_id' => 'consultant_id'])
        ->viaTable('student_consultant_relation', ['student_id' => 'student_id']);
    }

	
     
     public function getPackagedetails()
    { 
        return $this->hasMany(PackageType::className(), ['id' => 'package_type_id'])
        ->viaTable('student_package_details', ['student_id' => 'student_id']);
    }
	
	public function TaskStatus()
    {
         return array(0=>'Pending',1=>'In Progress', 2=>'Complete');
    }

	public function TaskActions()
    {
         return array(0=>'Pending',1=>'In Progress', 2=>'Complete');
    }
	
	public function TaskVerificationByCounselor()
    {
         return array(0=>'Pending',1=>'In Progress', 2=>'Complete');
    }
	
	public function TaskResponsbility()
    {
        return array(0=>'Student', 1=>'Consultant', 2=>'Others');
    }
	
	public function TaskSpecificAlert()
    {
        return array(1=>'1 day before deadline', 2=>'2 days before deadline', 3=>'3 days before deadline',
		5=>'5 days before deadline', 7=>'1 week before deadline',14=>'2 weeks before deadline');
    }

	 
    public function getTaskCategory()
    {
        return $this->hasOne(TaskCategory::className(), ['id' => 'task_category_id']);
    }
	 
    public function getTaskList()
    {
        return $this->hasOne(TaskList::className(), ['id' => 'task_list_id']);
    }
	
	public function getGenerateInvoiceTaskListId()
    {
        return '22';
    }
}
