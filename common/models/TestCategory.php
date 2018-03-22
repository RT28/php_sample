<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property StandardTests[] $standardTests
 */
class TestCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],        
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 50],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStandardTests()
    {
        return $this->hasMany(StandardTests::className(), ['test_category_id' => 'id']);
    }
}
