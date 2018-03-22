<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "task_list".
 *
 * @property integer $id
 * @property integer $task_category_id
 * @property string $name
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property TaskCategory $taskCategory
 */
class TaskList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_category_id', 'name'], 'required'],
            [['task_category_id'], 'integer'],
            [['created_at', 'updated_at','auto_assign'], 'safe'],
            [['name'], 'string', 'max' => 255],
			[['description','how_to_complete'], 'string', 'max' => 1000],
            [['created_by', 'updated_by'], 'string', 'max' => 50],
            [['task_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskCategory::className(), 'targetAttribute' => ['task_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_category_id' => 'Task Category ID',
            'name' => 'Name',
			'description' => 'Description',
			'how_to_complete' => 'How to complete',
			'auto_assign' => 'Is auto assign task for student after sign up?',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public  function getTaskCategory()
    {
        return $this->hasOne(TaskCategory::className(), ['id' => 'task_category_id']);
    }
	
	public  function getAllTaskList() {
        $lists = TaskList::find()->orderBy('name','ASC')->all();
        return ArrayHelper::map($lists, 'id', 'name');
    }

}
