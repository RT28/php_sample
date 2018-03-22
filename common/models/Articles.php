<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $name
 * @property string $description 
 * @property integer $active
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'active','description','short_description','view_duration', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [[ 'active', 'created_by', 'updated_by','view_duration'], 'integer'],
            [['created_at', 'updated_at', 'view_count'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['description','short_description'], 'string'],
			[['name'], 'unique', 'targetAttribute' => ['name'], 'message' => 'The Name has already been taken.'],
            
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
            'description' => 'Description', 
            'active' => 'Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}
