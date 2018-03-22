<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $rank
 * @property integer $active
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rank', 'active', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['rank', 'active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','name_fa','description_fa'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 5000],
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
            'name_fa' => 'Name in Farsi',
            'description_fa' => 'Description in Farsi',
            'rank' => 'Rank',
            'active' => 'Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}
