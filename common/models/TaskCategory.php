<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\TaskList;
/**
 * This is the model class for table "task_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $updated_at
 */
class TaskCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
			[['position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
			'position' => 'Position',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskList() 
    {
        return $this->hasMany(TaskList::className(), ['task_category_id' => 'id']);
    }
	
	public  function getAllTaskCategories() {
        $categories = TaskCategory::find()->orderBy('name','ASC')->all();
        return ArrayHelper::map($categories, 'id', 'name');
    }

}
