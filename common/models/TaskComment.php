<?php


namespace common\models;

use Yii;

/**
 * This is the model class for table "task_comment".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $consultant_id
 * @property integer $counselor_id
 * @property string $comment
 * @property integer $action
 * @property integer $status
 * @property integer $created_by
 * @property integer $created_at
 */
class TaskComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		[['task_id','comment', 'action', 'status', 'created_by', 'created_at'], 'required'],
		[['student_id', 'consultant_id', 'action', 'status'], 'integer'],
		[['created_by', 'created_at'], 'safe'],
		[['comment'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'task_id' => 'Task',
            'student_id' => 'Student',
            'consultant_id' => 'Consultant', 
            'comment' => 'Comment',
            'action' => 'Action',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }
}
