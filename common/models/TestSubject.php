<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test_subject".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class TestSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[  'name', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'], 
            [['created_at', 'created_by', 'updated_by','updated_at'], 'safe'],
            [['name'], 'string', 'max' => 250],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
