<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "consultant_tasks".
 *
 * @property integer $id
 * @property integer $consultant_id
 * @property integer $task_category_id
 * @property integer $task_list_id
 * @property string $title
 * @property string $description
 * @property string $due_date
 * @property string $comments
 * @property string $attachment
 * @property integer $status
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 */
class ConsultantTasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consultant_tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultant_id', 'task_category_id', 'task_list_id', 'title', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['consultant_id', 'task_category_id', 'task_list_id', 'status'], 'integer'],
            [['title', 'description', 'comments'], 'string'],
            [['due_date', 'created_at', 'updated_at'], 'safe'],
            [['attachment'], 'string', 'max' => 255],
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
            'consultant_id' => 'Consultant ID',
            'task_category_id' => 'Task Category ID',
            'task_list_id' => 'Task List ID',
            'title' => 'Title',
            'description' => 'Description',
            'due_date' => 'Due Date',
            'comments' => 'Comments',
            'attachment' => 'Attachment',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
	
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskCategory()
    {
        return $this->hasOne(TaskCategory::className(), ['id' => 'task_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskList()
    {
        return $this->hasOne(TaskList::className(), ['id' => 'task_list_id']);
    }
}
